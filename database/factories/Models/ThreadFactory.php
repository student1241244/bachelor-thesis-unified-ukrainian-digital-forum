<?php

namespace Database\Factories\Models;

use Packages\Threads\App\Models\Thread;
use Packages\Threads\App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'is_passcode_user' => $this->faker->numberBetween(0, [1]),
            'report_count' => 0,
            'report_data' => null,
        ];
    }
}