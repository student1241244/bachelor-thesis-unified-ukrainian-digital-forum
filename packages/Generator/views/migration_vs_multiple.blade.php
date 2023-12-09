<?= '<?php'?>

use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {{ $class_name }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('{{ $table_name }}', function (Blueprint $table) {
            $table->foreignId('{{ $self_id }}');
            $table->foreignId('{{ $rel_id }}');

            $table->foreign('{{ $self_id }}')->references('id')->on('{{ $self_table }}')->onDelete('cascade');
            $table->foreign('{{ $rel_id }}')->references('id')->on('{{ $rel_table }}')->onDelete('cascade');

        }, false, false, false);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop('{{ $table_name }}');
    }
}
