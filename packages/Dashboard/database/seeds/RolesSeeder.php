<?php

use Illuminate\Database\Seeder;
use Packages\Dashboard\App\Models\Role;
use Illuminate\Support\Str;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'title' => Str::studly(Role::SLUG_ADMIN),
        ]);
    }
}
