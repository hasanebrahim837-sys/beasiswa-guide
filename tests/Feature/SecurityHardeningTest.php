<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
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

    public function test_registration_is_closed_by_default(): void
    {
        $this->withoutVite();
        config(['app.registration_enabled' => false]);

        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Someone', 'email' => 'someone@example.test',
            'password' => 'password-123', 'password_confirmation' => 'password-123',
        ])->assertNotFound();
        $this->assertDatabaseMissing('users', ['email' => 'someone@example.test']);
        $this->get('/')->assertDontSee(url('/register'));
    }

    public function test_language_switch_never_redirects_to_another_site(): void
    {
        $this->get('/lang/en', ['referer' => 'https://evil.example.com/phish'])
            ->assertRedirect(route('home'));

        $this->get('/lang/ar', ['referer' => url('/scholarships')])
            ->assertRedirect(url('/scholarships'));
    }

    public function test_pages_send_security_headers(): void
    {
        $this->withoutVite();

        $this->get('/')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    public function test_assistance_request_needs_consent(): void
    {
        $scholarship = $this->scholarship();

        $this->post(route('assistance.store', $scholarship), [
            'full_name' => 'Student', 'email' => 'student@example.test',
        ])->assertSessionHasErrors('consent');

        $this->assertDatabaseCount('assistance_requests', 0);
    }

    public function test_assistance_requests_are_rate_limited(): void
    {
        Storage::fake('local');
        $scholarship = $this->scholarship();
        $data = ['full_name' => 'Student', 'email' => 'student@example.test', 'consent' => '1'];

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('assistance.store', $scholarship), $data)->assertSessionHasNoErrors();
        }

        $this->post(route('assistance.store', $scholarship), $data)
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseCount('assistance_requests', 5);
    }

    public function test_make_admin_promotes_an_existing_account(): void
    {
        $user = User::factory()->create(['email' => 'owner@example.test', 'role' => 'student']);

        $this->artisan('make:admin', ['--email' => 'owner@example.test'])->assertSuccessful();

        $this->assertSame('admin', $user->fresh()->role);
    }

    public function test_make_admin_creates_a_new_admin(): void
    {
        $this->artisan('make:admin', ['--email' => 'new-admin@example.test'])
            ->expectsQuestion('Admin name', 'New Admin')
            ->expectsQuestion('Password (at least 10 characters)', 'a-strong-password')
            ->expectsQuestion('Repeat the password', 'a-strong-password')
            ->assertSuccessful();

        $admin = User::where('email', 'new-admin@example.test')->firstOrFail();
        $this->assertSame('admin', $admin->role);
        $this->assertTrue(Hash::check('a-strong-password', $admin->password));
    }
}
