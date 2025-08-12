<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contribution;
use App\Models\User;

class ContributionFactory extends Factory
{
    protected $model = Contribution::class;

    public function definition(): array
    {
        return [
            'recipient_name_encrypted' => encrypt($this->faker->name),
            'recipient_ic_encrypted' => encrypt($this->faker->numerify('###########')),
            'recipient_phone_encrypted' => encrypt($this->faker->phoneNumber),
            'recipient_address_encrypted' => encrypt($this->faker->address),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'contribution_type' => $this->faker->randomElement(['Cash', 'Cheque', 'Bank Transfer']),
            'category' => $this->faker->randomElement(['Medical', 'Education', 'Emergency', 'Business', 'Housing', 'Food']),
            'description' => $this->faker->sentence,
            'payment_method' => $this->faker->randomElement(['cash', 'cheque']),
            'contribution_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'voucher_number' => 'VCH' . strtoupper(uniqid()),
            'location' => $this->faker->city,
            'status' => 'approved',
            'created_by' => User::factory(),
            'approved_by' => User::factory(),
            'approved_at' => now(),
        ];
    }

    public function pending(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_by' => null,
                'approved_at' => null,
            ];
        });
    }

    public function approved(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'approved_at' => now(),
            ];
        });
    }

    public function rejected(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'rejected',
                'approved_at' => now(),
            ];
        });
    }
}