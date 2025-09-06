<?php

namespace Database\Factories;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Broker>
 */
class BrokerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Broker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'account_balance' => fake()->randomFloat(2, 0, 100000), // Random balance between 0 and 100,000
        ];
    }

    /**
     * Indicate that the broker should have a high balance.
     */
    public function highBalance()
    {
        return $this->state(function (array $attributes) {
            return [
                'account_balance' => fake()->randomFloat(2, 50000, 200000),
            ];
        });
    }

    /**
     * Indicate that the broker should have a low balance.
     */
    public function lowBalance()
    {
        return $this->state(function (array $attributes) {
            return [
                'account_balance' => fake()->randomFloat(2, 0, 1000),
            ];
        });
    }

    /**
     * Indicate that the broker should have zero balance.
     */
    public function zeroBalance()
    {
        return $this->state(function (array $attributes) {
            return [
                'account_balance' => 0.00,
            ];
        });
    }
}