<?php
use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('threads_comments', function (Blueprint $table) {
			$table->foreignId('thread_id')->nullable();
			$table->string('body');
			$table->foreign('thread_id')->references('id')->on('threads')->onDelete('SET NULL');
        }, false, true, true);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop('comments');
    }
}
