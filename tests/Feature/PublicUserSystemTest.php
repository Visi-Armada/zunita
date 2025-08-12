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
        $response->assertSee('Transparency Dashboard');
    }

    /** @test */
    public function registration_form_is_accessible()
    {
        $response = $this->get('/auth/register');
        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    /** @test */
    public function login_form_is_accessible()
    {
        $response = $this->get('/auth/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    /** @test */
    public function public_user_can_register()
    {
        $response = $this->post('/auth/register', [
            'full_name' => 'Test User',
            'ic_number' => '901234567890',
            'email' => 'test@example.com',
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertDatabaseHas('public_users', [
            'email' => 'test@example.com',
            'ic_number' => '901234567890',
        ]);
    }

    /** @test */
    public function complaint_form_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/user/forms/complaint');
        
        $response->assertStatus(200);
        $response->assertSee('File a Complaint');
    }

    /** @test */
    public function application_form_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/user/forms/application');
        
        $response->assertStatus(200);
        $response->assertSee('Apply for Financial Assistance');
    }

    /** @test */
    public function initiative_form_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/user/forms/initiative');
        
        $response->assertStatus(200);
        $response->assertSee('Propose Community Initiative');
    }

    /** @test */
    public function contribution_request_form_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/user/forms/contribution-request');
        
        $response->assertStatus(200);
        $response->assertSee('Request Program Funding');
    }

    /** @test */
    public function user_dashboard_is_accessible_for_authenticated_users()
    {
        $user = PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')
                         ->get('/user/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }
}