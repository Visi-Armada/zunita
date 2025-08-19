<?php

namespace Tests\Feature;

use App\Models\PublicUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicUserSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_dashboard_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Transparensi');
        $response->assertSee('Statistik');
    }

    public function test_registration_form_is_accessible()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akaun Baru');
    }

    public function test_login_form_is_accessible()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali');
    }

    public function test_public_user_can_register()
    {
        $response = $this->post('/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'ic_number' => '901234567890',
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'postcode' => '12345',
            'city' => 'Test City',
            'state' => 'Selangor',
            'preferred_language' => 'english',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('public_users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_public_user_can_login()
    {
        $user = PublicUser::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated('public');
    }

    public function test_user_dashboard_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }

    public function test_initiatives_page_is_accessible()
    {
        $response = $this->get('/initiatives');
        $response->assertStatus(200);
        $response->assertSee('Inisiatif');
        $response->assertSee('Program');
    }

    public function test_profile_page_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/profile');
        
        $response->assertStatus(200);
    }
}