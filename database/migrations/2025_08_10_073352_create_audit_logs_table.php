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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            
            // User information
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('user_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('session_id')->nullable();
            
            // Action details
            $table->string('action'); // create, update, delete, login, logout, etc.
            $table->string('model_type')->nullable(); // Contribution, User, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected record
            $table->string('model_identifier')->nullable(); // Voucher number, email, etc.
            
            // Data changes
            $table->json('old_values')->nullable(); // Previous values
            $table->json('new_values')->nullable(); // New values
            $table->json('changed_fields')->nullable(); // Which fields changed
            
            // Context
            $table->string('route')->nullable(); // Route name
            $table->string('method')->nullable(); // HTTP method
            $table->text('url')->nullable(); // Full URL
            $table->json('request_data')->nullable(); // Request data (sanitized)
            
            // Security
            $table->string('risk_level')->default('low'); // low, medium, high, critical
            $table->text('security_notes')->nullable(); // Security-related notes
            
            // Metadata
            $table->timestamp('performed_at');
            $table->timestamps();
            
            // Indexes for performance and security monitoring
            $table->index(['user_id', 'performed_at']);
            $table->index(['action', 'performed_at']);
            $table->index(['model_type', 'model_id']);
            $table->index(['risk_level', 'performed_at']);
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
