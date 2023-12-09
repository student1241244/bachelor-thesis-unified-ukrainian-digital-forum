<?php
use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('threads', function (Blueprint $table) {
			$table->foreignId('category_id')->nullable();
			$table->string('title');
			$table->text('body')->nullable();
			$table->foreign('category_id')->references('id')->on('threads_categories')->onDelete('SET NULL');
        }, false, true, true);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop('threads');
    }
}
