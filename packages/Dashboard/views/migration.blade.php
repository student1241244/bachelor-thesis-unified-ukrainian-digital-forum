<?= "<?php\n"?>

use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {{ $name }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('{{ $table }}', function (Blueprint $table) {
            $table->boolean('is_active')->default('0');
        }, false);

        $this->createTranslationFor('{{ $table }}', function (Blueprint $table) {
            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->dropWithTranslations('{{ $table }}');
    }
}
