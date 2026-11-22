<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Scholarship;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScholarshipVisibilityTest extends TestCase
{
    use RefreshDatabase;

    private function makeScholarship(string $title, ?string $deadline, bool $active = true): Scholarship
    {
        $country = Country::firstOrCreate(['code' => 'ID'], ['name' => 'Indonesia']);

        return Scholarship::create([
            'country_id' => $country->id,
            'title' => $title,
            'degree' => 'Master',
            'official_link' => 'https://example.org',
            'deadline' => $deadline,
            'is_active' => $active,
        ]);
    }

    public function test_closed_inactive_and_open_scholarships_are_listed_correctly(): void
    {
        $this->withoutVite();

        $this->makeScholarship('Open Scholarship', now()->addMonth()->toDateString());
        $this->makeScholarship('Not Announced Scholarship', null);
        $this->makeScholarship('Closed Scholarship', now()->subDay()->toDateString());
        $this->makeScholarship('Hidden Scholarship', now()->addMonth()->toDateString(), active: false);

        foreach (['/', '/scholarships'] as $url) {
            $this->withSession(['locale' => 'en'])->get($url)
                ->assertOk()
                ->assertSee('Open Scholarship')
                ->assertSee('Not Announced Scholarship')
                ->assertDontSee('Closed Scholarship')
                ->assertDontSee('Hidden Scholarship');
        }
    }

    public function test_seeder_hides_samples_and_keeps_drafts_inactive(): void
    {
        $sample = $this->makeScholarship('KNB Scholarship', '2026-12-31');

        $this->seed(\Database\Seeders\ScholarshipsSeeder::class);

        $this->assertFalse((bool) $sample->fresh()->is_active);
        $this->assertTrue((bool) Scholarship::where('title', 'UIII Admissions & Scholarships 2027')->value('is_active'));
        $this->assertFalse((bool) Scholarship::where('title', 'UMY International Student Scholarship 2027/2028')->value('is_active'));

        // Re-running does not overwrite a draft the consultant has corrected and activated.
        Scholarship::where('title', 'UMY International Student Scholarship 2027/2028')
            ->update(['is_active' => true, 'description' => 'Checked by the consultant']);
        $this->seed(\Database\Seeders\ScholarshipsSeeder::class);
        $this->assertSame('Checked by the consultant', Scholarship::where('title', 'UMY International Student Scholarship 2027/2028')->value('description'));
    }
}
