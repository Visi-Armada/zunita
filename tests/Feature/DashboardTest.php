<?php

namespace Tests\Feature;

use App\Models\Contribution;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_dashboard_loads_correctly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Transparency Dashboard');
        $response->assertSee('YB Dato\' Zunita Begum');
    }

    /** @test */
    public function dashboard_api_returns_data()
    {
        // Create test contributions
        $user = User::factory()->create();
        
        Contribution::factory()->count(5)->create([
            'status' => 'approved',
            'created_by' => $user->id
        ]);

        $response = $this->getJson('/api/dashboard-data');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'total_contributions',
                'total_beneficiaries',
                'active_initiatives',
                'monthly_contributions',
                'monthly_labels',
                'monthly_data',
                'category_labels',
                'category_data',
                'recent_contributions',
                'initiatives'
            ]
        ]);
    }

    /** @test */
    public function admin_dashboard_requires_authentication()
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_dashboard_loads_for_authenticated_users()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    /** @test */
    public function admin_stats_api_requires_authentication()
    {
        $response = $this->getJson('/api/admin-stats');
        $response->assertStatus(401);
    }

    /** @test */
    public function admin_stats_api_returns_data_for_authenticated_users()
    {
        $user = User::factory()->create();
        
        Contribution::factory()->count(3)->create([
            'created_by' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson('/api/admin-stats');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'data' => [
                'total_contributions',
                'total_recipients',
                'today_entries',
                'pending_review'
            ]
        ]);
    }

    /** @test */
    public function recipient_lookup_api_works()
    {
        $user = User::factory()->create();
        
        Contribution::factory()->create([
            'recipient_ic_encrypted' => '901234567890',
            'recipient_name_encrypted' => 'John Doe',
            'recipient_phone_encrypted' => '0123456789',
            'recipient_address_encrypted' => '123 Main St',
            'created_by' => $user->id
        ]);

        $response = $this->actingAs($user)->getJson('/api/recipients/901234567890');
        $response->assertStatus(200);
    }
}