<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Threads\App\Models\Comment;
use Packages\Threads\App\Models\Thread;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {   
        return [
            'body' => 'This is a test comment.',
            'is_passcode_user' => $this->faker->boolean,
            'report_data' => ['Spam']
        ];
    }
}
