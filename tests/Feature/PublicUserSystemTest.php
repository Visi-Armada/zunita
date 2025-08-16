<?php

namespace Tests\Feature;

use App\Models\PublicUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicUserSystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_dashboard_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Transparensi');
        $response->assertSee('Impak');
    }

    /** @test */
    public function registration_form_is_accessible()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akaun Baru');
    }

    /** @test */
    public function login_form_is_accessible()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
        $response->assertSee('Selamat Datang Kembali');
    }

    /** @test */
    public function public_user_can_register()
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

    /** @test */
    public function public_user_can_login()
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

    /** @test */
    public function user_dashboard_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }

    /** @test */
    public function initiatives_page_is_accessible()
    {
        $response = $this->get('/initiatives');
        $response->assertStatus(200);
        $response->assertSee('Inisiatif');
        $response->assertSee('Program');
    }

    /** @test */
    public function profile_page_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/profile');
        
        $response->assertStatus(200);
    }
}