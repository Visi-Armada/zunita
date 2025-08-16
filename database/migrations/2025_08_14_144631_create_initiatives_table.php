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
        Schema::create('initiatives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->text('short_description')->nullable();
            $table->string('category');
            $table->longText('eligibility_criteria')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('requirements')->nullable();
            $table->timestamp('application_deadline')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('max_applications')->nullable();
            $table->integer('current_applications')->default(0);
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->string('featured_image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->decimal('budget_amount', 15, 2)->nullable();
            $table->decimal('budget_used', 15, 2)->default(0);
            $table->string('location')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('application_form_data')->nullable();
            $table->json('notification_settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'application_deadline']);
            $table->index(['category', 'is_featured']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initiatives');
    }
};
