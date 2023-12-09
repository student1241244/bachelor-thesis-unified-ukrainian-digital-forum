<?php

use Illuminate\Database\Migrations\Migration;
use Packages\Dashboard\App\Models\{
    Role,
    User
};

class SeedDefaultData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role = Role::create([
            'title' => \Illuminate\Support\Str::studly(Role::SLUG_ADMIN),
        ]);

        User::create([
            'email' => config('tpx_dashboard.seeders.user.email'),
            'password' => config('tpx_dashboard.seeders.user.password'),
            'is_admin' => 1,
            'username' => 'admin',
            'role_id' => $role->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
