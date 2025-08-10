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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            
            // Encrypted sensitive data
            $table->text('recipient_name_encrypted'); // Encrypted recipient name
            $table->text('recipient_ic_encrypted'); // Encrypted IC number
            $table->text('recipient_phone_encrypted'); // Encrypted phone number
            $table->text('recipient_address_encrypted'); // Encrypted address
            
            // Public data (for transparency)
            $table->decimal('amount', 10, 2); // Public amount
            $table->string('contribution_type'); // Public type
            $table->string('category'); // Public category
            $table->text('description'); // Public description
            $table->string('payment_method'); // Cash/Cheque
            $table->string('cheque_number')->nullable(); // Public if cheque
            
            // Metadata
            $table->date('contribution_date');
            $table->string('voucher_number')->unique(); // Unique voucher ID
            $table->string('location')->nullable(); // GPS location
            $table->json('documents')->nullable(); // Encrypted document paths
            
            // Status and tracking
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            
            // Audit trail
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['contribution_date', 'category']);
            $table->index(['status', 'created_by']);
            $table->index('voucher_number');
            
            // Soft deletes for audit trail
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
