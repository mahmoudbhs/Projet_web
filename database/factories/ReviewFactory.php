<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'content' => $this->faker->sentence(),
            'sentiment' => $this->faker->randomElement(['positive', 'neutral', 'negative']),
            'score' => $this->faker->numberBetween(0, 100),
            'topics' => ['quality'],
        ];
    }
}
