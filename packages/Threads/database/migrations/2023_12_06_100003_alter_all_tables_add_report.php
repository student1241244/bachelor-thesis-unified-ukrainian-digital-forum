<?php
use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAllTablesAddReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->table('threads_comments', function (Blueprint $table) {
			$table->unsignedInteger('report_count')->default(0);
			$table->longText('report_data')->nullable();
        });

        $this->table('threads', function (Blueprint $table) {
			$table->unsignedInteger('report_count')->default(0);
			$table->longText('report_data')->nullable();
        });

        $this->table('questions', function (Blueprint $table) {
			$table->unsignedInteger('report_count')->default(0);
			$table->longText('report_data')->nullable();
        });

        $this->table('comments', function (Blueprint $table) {
			$table->unsignedInteger('report_count')->default(0);
			$table->longText('report_data')->nullable();
        });
    }

}
