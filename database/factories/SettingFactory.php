<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition()
    {
        return [
            'setting_name' => $this->faker->unique()->word,
            'setting_status' => $this->faker->randomElement(['on', 'off']),
        ];
    }
}