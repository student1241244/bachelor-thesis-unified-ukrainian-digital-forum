<?php

use Illuminate\Database\Seeder;
use Packages\Dashboard\App\Models\{
    User,
    Role
};

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@admin.com',
            'password' => '123123',
            'role_id' => Role::where('slug', Role::SLUG_ADMIN)->first()->id,
        ]);
    }
}
