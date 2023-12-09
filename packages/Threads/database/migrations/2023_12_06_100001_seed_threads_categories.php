<?php
use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SeedThreadsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $list = [
            'Politics',
            'Science',
            'Economy',
            'Life Style'
        ];

        foreach ($list as $title) {
            \Packages\Threads\App\Models\Category::create(compact('title'));
        }
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
