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
        Schema::create('page_content', function (Blueprint $table) {
            $table->id();
            $table->string('section_name');     // 'carousel', 'about', 'contact', etc.
            $table->string('title');            // Section title
            $table->longText('content');        // Rich text content
            $table->json('images')->nullable(); // Simple image array
            $table->json('settings')->nullable(); // Basic settings
            $table->boolean('is_active')->default(true); // Show/hide section
            $table->integer('sort_order')->default(0); // Order on page
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who created/updated
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['section_name', 'is_active']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_content');
    }
};
