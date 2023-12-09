<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Packages\Dashboard\App\Models\Language::create([
            'code' => 'en',
            'title' => 'English',
        ]);
        Packages\Dashboard\App\Models\Language::create([
            'code' => 'ua',
            'title' => 'Українська',
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
