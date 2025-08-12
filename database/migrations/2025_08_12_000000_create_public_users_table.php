<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('ic_number')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('occupation')->nullable();
            $table->enum('income_bracket', ['below_1000', '1000_3000', '3000_5000', '5000_10000', 'above_10000'])->nullable();
            $table->integer('household_size')->nullable();
            $table->enum('preferred_language', ['malay', 'english', 'chinese', 'tamil'])->default('malay');
            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('profile_completed')->default(false);
            $table->boolean('consent_marketing')->default(false);
            $table->boolean('consent_data_sharing')->default(false);
            $table->rememberToken();
            $table->timestamps();
            
            $table->index(['ic_number', 'email']);
            $table->index(['state', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_users');
    }
};