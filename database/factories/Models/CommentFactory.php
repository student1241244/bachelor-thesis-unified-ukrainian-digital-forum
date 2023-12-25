<?php

namespace Database\Factories\Models;

use Packages\Threads\App\Models\Comment;
use Packages\Threads\App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'thread_id' => Thread::inRandomOrder()->first()->id,
            'body' => $this->faker->text,
            'report_count' => 0,
            'report_data' => null,
            'is_passcode_user' => $this->faker->numberBetween(0, [1]),
        ];
    }
}