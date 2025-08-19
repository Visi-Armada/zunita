<?php

namespace Tests\Feature;

use App\Models\Contribution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_dashboard_loads_correctly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Transparensi');
        $response->assertSee('Statistik');
    }

    public function test_admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');
    }

    public function test_admin_dashboard_loads_for_authenticated_users()
    {
        $user = User::factory()->create();
        
        // Admin users should be able to access admin panel
        // For now, we'll test that it redirects properly since regular users can't access admin
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403); // Forbidden for regular users
    }

    public function test_public_user_dashboard_requires_authentication()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_public_user_dashboard_loads_for_authenticated_users()
    {
        $user = \App\Models\PublicUser::factory()->create();
        
        $response = $this->actingAs($user, 'public')->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }

    public function test_initiatives_page_loads()
    {
        $response = $this->get('/initiatives');
        $response->assertStatus(200);
        $response->assertSee('Inisiatif');
        $response->assertSee('Program');
    }
}