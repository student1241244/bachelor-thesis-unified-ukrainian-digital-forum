<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User; // Ensure you have User model
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => User::inRandomOrder()->first()->id, // Random user ID
            'category_id' => $this->faker->numberBetween(1, [4]),
            'votes_count' => $this->faker->numberBetween(0, 100),
        ];
    }
}
