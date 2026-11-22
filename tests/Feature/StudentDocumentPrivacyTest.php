<?php

namespace Tests\Feature;

use App\Models\AssistanceRequest;
use App\Models\Country;
use App\Models\Document;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentDocumentPrivacyTest extends TestCase
{
    use RefreshDatabase;

    private function scholarship(): Scholarship
    {
        $country = Country::create(['name' => 'Indonesia', 'code' => 'ID']);

        return Scholarship::create([
            'country_id' => $country->id,
            'title' => 'Test Scholarship',
            'degree' => 'Master',
            'official_link' => 'https://example.org',
            'is_active' => true,
        ]);
    }

    private function uploadPassport(): Document
    {
        $scholarship = $this->scholarship();

        $this->post(route('assistance.store', $scholarship), [
            'full_name' => 'Student Name',
            'email' => 'student@example.test',
            'passport' => UploadedFile::fake()->create('passport.pdf', 100, 'application/pdf'),
            'consent' => '1',
        ])->assertRedirect();

        return Document::firstOrFail();
    }

    public function test_uploaded_documents_are_stored_privately(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $document = $this->uploadPassport();

        Storage::disk('local')->assertExists($document->file_path);
        Storage::disk('public')->assertMissing($document->file_path);
    }

    public function test_only_admins_can_open_documents(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        $document = $this->uploadPassport();
        $url = route('admin.documents.show', $document);

        // Visitor: sent to the login page.
        $this->get($url)->assertRedirect(route('login'));

        // Logged-in student: refused.
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student)->get($url)->assertForbidden();

        // Admin: can open it, without caching.
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get($url);
        $response->assertOk();
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertSame('nosniff', $response->headers->get('X-Content-Type-Options'));
    }

    public function test_migration_moves_old_public_documents_to_private_storage(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $scholarship = $this->scholarship();
        $request = AssistanceRequest::create([
            'scholarship_id' => $scholarship->id,
            'full_name' => 'Old Student',
            'email' => 'old@example.test',
            'status' => 'Pending',
        ]);
        Storage::disk('public')->put('assistance-documents/old.pdf', 'old file');
        Document::create([
            'assistance_request_id' => $request->id,
            'document_type' => 'Passport',
            'file_path' => 'assistance-documents/old.pdf',
            'original_name' => 'old.pdf',
        ]);

        $migration = require database_path('migrations/2026_11_23_000000_move_student_documents_to_private_storage.php');
        $migration->up();

        Storage::disk('local')->assertExists('assistance-documents/old.pdf');
        Storage::disk('public')->assertMissing('assistance-documents/old.pdf');
        $this->assertSame('old file', Storage::disk('local')->get('assistance-documents/old.pdf'));
    }
}
