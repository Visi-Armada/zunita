<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('initiative_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('initiative_id');
            $table->unsignedBigInteger('public_user_id');
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'on_hold'])->default('pending');
            $table->json('application_data');
            $table->text('admin_notes')->nullable();
            $table->text('user_notes')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->integer('priority_score')->default(3);
            $table->boolean('is_urgent')->default(false);
            $table->string('contact_preference')->default('email');
            $table->json('additional_documents')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['initiative_id', 'status']);
            $table->index(['public_user_id', 'status']);
            $table->index(['status', 'submitted_at']);
            $table->index('is_urgent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initiative_applications');
    }
};
