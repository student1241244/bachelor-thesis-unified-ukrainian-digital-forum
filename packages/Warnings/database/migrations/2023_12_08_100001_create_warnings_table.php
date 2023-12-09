<?php
use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->drop('warnings');

        $this->create('warnings', function (Blueprint $table) {
			$table->foreignId('user_id')->nullable();
			$table->text('body')->nullable();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');

        }, false, true, true);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop('warnings');
    }
}
