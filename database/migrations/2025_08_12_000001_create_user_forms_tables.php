<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Complaints table
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_user_id')->constrained('public_users');
            $table->string('title');
            $table->text('description');
            $table->enum('category', [
                'infrastructure',
                'utilities',
                'healthcare',
                'education',
                'employment',
                'housing',
                'transport',
                'environment',
                'safety',
                'other'
            ]);
            $table->string('location');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 10, 8)->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['submitted', 'under_review', 'in_progress', 'resolved', 'closed'])->default('submitted');
            $table->json('attachments')->nullable();
            $table->text('admin_response')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index(['public_user_id', 'status']);
            $table->index(['category', 'location']);
        });

        // Initiative submissions table
        Schema::create('initiative_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_user_id')->constrained('public_users');
            $table->string('title');
            $table->text('description');
            $table->enum('category', [
                'community_development',
                'education',
                'healthcare',
                'infrastructure',
                'environment',
                'economic',
                'social',
                'cultural',
                'sports',
                'technology'
            ]);
            $table->text('objectives');
            $table->text('expected_outcomes');
            $table->decimal('estimated_budget', 15, 2);
            $table->integer('target_beneficiaries');
            $table->date('proposed_start_date');
            $table->date('proposed_end_date');
            $table->string('location');
            $table->json('supporting_documents')->nullable();
            $table->enum('status', ['submitted', 'under_review', 'approved', 'rejected', 'implemented'])->default('submitted');
            $table->text('admin_feedback')->nullable();
            $table->timestamps();
            
            $table->index(['public_user_id', 'status']);
            $table->index(['category', 'location']);
        });

        // Applications for assistance table
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_user_id')->constrained('public_users');
            $table->string('application_number')->unique();
            $table->enum('type', [
                'financial_assistance',
                'medical_assistance',
                'education_assistance',
                'housing_assistance',
                'business_assistance',
                'emergency_assistance',
                'skill_training',
                'equipment_assistance'
            ]);
            $table->string('title');
            $table->text('description');
            $table->decimal('requested_amount', 15, 2);
            $table->text('justification');
            $table->json('supporting_documents')->nullable();
            $table->enum('status', ['submitted', 'under_review', 'approved', 'rejected', 'disbursed', 'closed'])->default('submitted');
            $table->decimal('approved_amount', 15, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->date('decision_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->timestamps();
            
            $table->index(['public_user_id', 'status']);
            $table->index(['type', 'status']);
        });

        // Contribution requests table
        Schema::create('contribution_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_user_id')->constrained('public_users');
            $table->string('title');
            $table->text('description');
            $table->enum('category', [
                'education',
                'healthcare',
                'community',
                'religious',
                'disaster_relief',
                'environment',
                'sports',
                'cultural',
                'infrastructure',
                'other'
            ]);
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('deadline');
            $table->string('beneficiary_name');
            $table->text('beneficiary_story');
            $table->json('supporting_documents')->nullable();
            $table->enum('status', ['active', 'completed', 'cancelled', 'expired'])->default('active');
            $table->timestamps();
            
            $table->index(['public_user_id', 'status']);
            $table->index(['category', 'status']);
        });

        // User notifications table
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('public_user_id')->constrained('public_users');
            $table->string('title');
            $table->text('message');
            $table->enum('type', ['info', 'success', 'warning', 'error']);
            $table->boolean('is_read')->default(false);
            $table->string('related_type')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamps();
            
            $table->index(['public_user_id', 'is_read']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('contribution_requests');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('initiative_submissions');
        Schema::dropIfExists('complaints');
    }
};