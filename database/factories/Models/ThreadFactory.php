<?php

namespace Database\Factories\Models;

use App\Models\User;
use Packages\Threads\App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;
    
    public function definition()
    {    
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'category_id' => '1',
            'report_data' => ['Spam']
        ];
    }
    
}
