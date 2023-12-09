<?php

use Illuminate\Database\Migrations\Migration;
use Packages\Dashboard\App\Models\{
    Role,
    User
};

class SeedResolveUsersData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roleUser = Role::create([
            'title' => \Illuminate\Support\Str::studly(Role::SLUG_USER),
        ]);

        $roleModerator = Role::create([
            'title' => \Illuminate\Support\Str::studly(Role::SLUG_MODERATOR),
        ]);

        User::query()
            ->whereNull('role_id')
            ->update([
            'role_id' => $roleUser->id,
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
