<?php

namespace Tests\Feature;

use App\Models\PublicUser;
use App\Notifications\PublicUserPasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PublicUserPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_user_can_access_forgot_password_page()
    {
        $response = $this->get('/auth/forgot-password');
        
        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Laluan');
        $response->assertSee('Masukkan alamat e-mel anda');
    }

    /** @test */
    public function public_user_can_request_password_reset()
    {
        Notification::fake();

        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        $response = $this->post('/auth/forgot-password', [
            'email' => 'test@example.com'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        
        // Check that password reset record was created
        $this->assertDatabaseHas('password_resets', [
            'email' => 'test@example.com'
        ]);

        // Check that notification was sent
        Notification::assertSentTo($user, PublicUserPasswordReset::class);
    }

    /** @test */
    public function public_user_can_access_reset_password_page_with_valid_token()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        // Create a password reset token
        $token = 'valid-token-123';
        DB::table('password_resets')->insert([
            'email' => 'test@example.com',
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $response = $this->get('/auth/reset-password/' . $token);
        
        $response->assertStatus(200);
        $response->assertSee('Set Semula Kata Laluan');
        $response->assertSee('Masukkan kata laluan baharu');
    }

    /** @test */
    public function public_user_can_reset_password_with_valid_token()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword')
        ]);

        // Create a password reset token
        $token = 'valid-token-123';
        DB::table('password_resets')->insert([
            'email' => 'test@example.com',
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $response = $this->post('/auth/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertRedirect('/auth/login');
        $response->assertSessionHas('success');

        // Check that password was updated
        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));

        // Check that password reset record was deleted
        $this->assertDatabaseMissing('password_resets', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function public_user_cannot_reset_password_with_invalid_token()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        $response = $this->post('/auth/reset-password', [
            'token' => 'invalid-token',
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors(['token']);
    }

    /** @test */
    public function public_user_cannot_reset_password_with_expired_token()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        // Create an expired password reset token (25 hours old)
        $token = 'expired-token-123';
        DB::table('password_resets')->insert([
            'email' => 'test@example.com',
            'token' => Hash::make($token),
            'created_at' => now()->subHours(25)
        ]);

        $response = $this->post('/auth/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors(['token']);
    }

    /** @test */
    public function public_user_cannot_reset_password_with_mismatched_passwords()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        // Create a password reset token
        $token = 'valid-token-123';
        DB::table('password_resets')->insert([
            'email' => 'test@example.com',
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $response = $this->post('/auth/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function public_user_cannot_reset_password_with_weak_password()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com'
        ]);

        // Create a password reset token
        $token = 'valid-token-123';
        DB::table('password_resets')->insert([
            'email' => 'test@example.com',
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $response = $this->post('/auth/reset-password', [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => '123',
            'password_confirmation' => '123'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function public_user_cannot_reset_password_for_nonexistent_email()
    {
        $response = $this->post('/auth/reset-password', [
            'token' => 'valid-token-123',
            'email' => 'nonexistent@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function forgot_password_link_exists_on_login_page()
    {
        $response = $this->get('/auth/login');
        
        $response->assertStatus(200);
        $response->assertSee('Lupa kata laluan?');
        $response->assertSee('href="/auth/forgot-password"');
    }

    /** @test */
    public function password_reset_request_does_not_reveal_email_existence()
    {
        $response = $this->post('/auth/forgot-password', [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        $response->assertSessionHas('status', 'Jika alamat e-mel wujud dalam sistem kami, pautan set semula kata laluan akan dihantar.');
    }

    /** @test */
    public function password_reset_email_contains_correct_information()
    {
        Notification::fake();

        $user = PublicUser::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test User'
        ]);

        $this->post('/auth/forgot-password', [
            'email' => 'test@example.com'
        ]);

        Notification::assertSentTo($user, PublicUserPasswordReset::class, function ($notification) {
            $mailMessage = $notification->toMail($notification->notifiable);
            
            return $mailMessage->subject === 'Set Semula Kata Laluan - YB Dato\' Zunita Begum' &&
                   str_contains($mailMessage->greeting, 'Test User') &&
                   str_contains($mailMessage->introLines[0], 'permintaan set semula kata laluan');
        });
    }
}
