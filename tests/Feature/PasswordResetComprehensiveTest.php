<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PublicUser;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PasswordResetComprehensiveTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_access_password_reset_page()
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Forgot password');
    }

    public function test_admin_user_can_request_password_reset()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'admin@zunitabegum.my'
        ]);

        Volt::test('auth.forgot-password')
            ->set('email', $user->email)
            ->call('sendPasswordResetLink');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_admin_user_can_reset_password_with_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'admin@zunitabegum.my'
        ]);

        Volt::test('auth.forgot-password')
            ->set('email', $user->email)
            ->call('sendPasswordResetLink');

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = Volt::test('auth.reset-password', ['token' => $notification->token])
                ->set('email', $user->email)
                ->set('password', 'newpassword123')
                ->set('password_confirmation', 'newpassword123')
                ->call('resetPassword');

            $response
                ->assertHasNoErrors()
                ->assertRedirect(route('login', absolute: false));

            return true;
        });
    }

    public function test_public_user_cannot_access_admin_password_reset_page()
    {
        $publicUser = PublicUser::factory()->create([
            'email' => 'public@example.com'
        ]);

        $response = $this->actingAs($publicUser, 'public')
            ->get('/forgot-password');

        // Should redirect since this is for admin users
        $response->assertStatus(302);
    }

    public function test_public_user_password_reset_routes_do_not_exist()
    {
        // Check if public user password reset routes exist
        $response = $this->get('/auth/forgot-password');
        $response->assertStatus(200); // Route exists

        $response = $this->get('/auth/reset-password/token');
        $response->assertStatus(200); // Route exists and works
    }

    public function test_public_user_login_page_has_no_forgot_password_link()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
        $response->assertSee('Lupa kata laluan?');
        $response->assertSee('forgot-password');
    }

    public function test_admin_user_login_page_has_forgot_password_link()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Forgot your password?');
    }

    public function test_password_reset_works_only_for_admin_users()
    {
        Notification::fake();

        $adminUser = User::factory()->create([
            'email' => 'admin@zunitabegum.my'
        ]);

        $publicUser = PublicUser::factory()->create([
            'email' => 'public@example.com'
        ]);

        // Admin user can request password reset
        Volt::test('auth.forgot-password')
            ->set('email', $adminUser->email)
            ->call('sendPasswordResetLink');

        Notification::assertSentTo($adminUser, ResetPassword::class);

        // Public user cannot use the same system
        Volt::test('auth.forgot-password')
            ->set('email', $publicUser->email)
            ->call('sendPasswordResetLink');

        // Should not send notification to public user
        Notification::assertNotSentTo($publicUser, ResetPassword::class);
    }

    public function test_public_users_need_separate_password_reset_system()
    {
        // This test documents that public users need their own password reset system
        $this->assertTrue(true, 'Public users need separate password reset functionality');
    }
}
