<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'body' => $this->faker->sentence,
            'question_id' => Question::inRandomOrder()->first()->id, // Random question ID
            'user_id' => User::inRandomOrder()->first()->id, // Random user ID
            'votes_count' => $this->faker->numberBetween(0, 50),
        ];
    }
}
