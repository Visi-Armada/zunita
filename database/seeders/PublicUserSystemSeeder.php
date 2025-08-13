<?php

namespace Database\Seeders;

use App\Models\PublicUser;
use App\Models\Complaint;
use App\Models\Application;
use App\Models\InitiativeSubmission;
use App\Models\ContributionRequest;
use App\Models\UserNotification;
use App\Models\Contribution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PublicUserSystemSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample public users
        $users = PublicUser::factory()->count(50)->create();

        // Create contributions for dashboard analytics
        $this->createContributions();
        
        // Create user submissions
        $this->createUserSubmissions($users);
        
        // Create notifications
        $this->createNotifications($users);
    }

    private function createContributions(): void
    {
        $categories = ['Education', 'Healthcare', 'Infrastructure', 'Social Welfare', 'Emergency Relief'];
        $locations = ['Kampung Baru', 'Taman Seri', 'Bandar Pilah', 'Desa Jaya', 'Kampung Melayu', 'Taman Indah', 'Seremban', 'Kuala Pilah'];
        
        // Create 6 months of contribution data
        for ($month = 0; $month < 6; $month++) {
            $date = now()->subMonths($month);
            
            for ($i = 0; $i < rand(15, 30); $i++) {
                $voucherNumber = 'ZB' . $date->format('Ym') . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
                Contribution::create([
                    'amount' => rand(500, 15000),
                    'category' => $categories[array_rand($categories)],
                    'location' => $locations[array_rand($locations)],
                    'description' => 'Monthly contribution for community development',
                    'contribution_date' => $date->copy()->subDays(rand(1, 28)),
                    'recipient_name' => fake()->name(),
                    'recipient_ic' => fake()->numerify('###########'),
                    'recipient_phone' => fake()->phoneNumber(),
                    'recipient_address' => fake()->address(),
                    'contribution_type' => 'individual',
                    'payment_method' => 'cash',
                    'voucher_number' => $voucherNumber,
                    'status' => 'approved',
                    'created_by' => 1,
                ]);
            }
        }
    }

    private function createUserSubmissions($users): void
    {
        foreach ($users as $user) {
            // Create complaints
            $complaintTypes = ['infrastructure', 'utilities', 'environment', 'safety', 'governance', 'other'];
            for ($i = 0; $i < rand(1, 3); $i++) {
                Complaint::create([
                    'public_user_id' => $user->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'category' => fake()->randomElement(['infrastructure', 'utilities', 'healthcare', 'education', 'safety', 'environment', 'other']),
                    'location' => fake()->address(),
                    'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
                    'status' => fake()->randomElement(['submitted', 'under_review', 'in_progress', 'resolved', 'closed']),
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);
            }

            // Create applications
            $applicationTypes = ['financial_assistance', 'medical_assistance', 'education_assistance', 'housing_assistance', 'business_assistance', 'emergency_assistance'];
            for ($i = 0; $i < rand(1, 2); $i++) {
                Application::create([
                    'public_user_id' => $user->id,
                    'application_number' => 'APP' . strtoupper(uniqid()),
                    'type' => $applicationTypes[array_rand($applicationTypes)],
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(),
                    'requested_amount' => rand(500, 5000),
                    'justification' => fake()->paragraph(),
                    'status' => fake()->randomElement(['submitted', 'under_review', 'approved', 'rejected', 'disbursed', 'closed']),
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);
            }

            // Create initiatives
            $initiativeCategories = ['community_development', 'education', 'healthcare', 'infrastructure', 'environment', 'economic', 'social', 'cultural', 'sports', 'technology'];
            for ($i = 0; $i < rand(0, 2); $i++) {
                InitiativeSubmission::create([
                    'public_user_id' => $user->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(3),
                    'category' => $initiativeCategories[array_rand($initiativeCategories)],
                    'objectives' => fake()->paragraph(2),
                    'expected_outcomes' => fake()->paragraph(2),
                    'estimated_budget' => rand(1000, 20000),
                    'target_beneficiaries' => rand(10, 100),
                    'proposed_start_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                    'proposed_end_date' => fake()->dateTimeBetween('+2 months', '+6 months')->format('Y-m-d'),
                    'location' => fake()->address(),
                    'status' => fake()->randomElement(['submitted', 'under_review', 'approved', 'rejected', 'implemented']),
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);
            }

            // Create contribution requests
            $contributionCategories = ['education', 'healthcare', 'community', 'religious', 'disaster_relief', 'environment', 'sports', 'cultural', 'infrastructure', 'other'];
            for ($i = 0; $i < rand(0, 2); $i++) {
                ContributionRequest::create([
                    'public_user_id' => $user->id,
                    'title' => fake()->sentence(),
                    'description' => fake()->paragraph(2),
                    'category' => $contributionCategories[array_rand($contributionCategories)],
                    'target_amount' => rand(500, 10000),
                    'current_amount' => rand(0, 5000),
                    'deadline' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
                    'beneficiary_name' => fake()->name(),
                    'beneficiary_story' => fake()->paragraph(3),
                    'status' => fake()->randomElement(['active', 'completed', 'cancelled', 'expired']),
                    'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
                ]);
            }
        }
    }

    private function createNotifications($users): void
    {
        foreach ($users as $user) {
            // Create welcome notification
            UserNotification::create([
                'public_user_id' => $user->id,
                'type' => 'info',
                'title' => 'Welcome!',
                'message' => 'Welcome to YB Dato\' Zunita Begum\'s constituency portal!',
                'created_at' => $user->created_at,
            ]);

            // Create random notifications
            $notificationTypes = ['info', 'success', 'warning', 'error'];
            $notificationTitles = [
                'Complaint Submitted',
                'Application Received',
                'Initiative Proposal',
                'Contribution Request',
                'Status Update',
                'Important Reminder'
            ];

            for ($i = 0; $i < rand(1, 5); $i++) {
                UserNotification::create([
                    'public_user_id' => $user->id,
                    'type' => $notificationTypes[array_rand($notificationTypes)],
                    'title' => $notificationTitles[array_rand($notificationTitles)],
                    'message' => fake()->sentence(),
                    'related_type' => fake()->randomElement(['complaint', 'application', 'initiative', 'contribution_request']),
                    'related_id' => rand(1, 100),
                    'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
                ]);
            }
        }
    }
}