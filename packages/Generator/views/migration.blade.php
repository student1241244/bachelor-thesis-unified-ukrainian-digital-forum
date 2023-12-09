<?= '<?php'?>

use Packages\Dashboard\App\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class {{ $className }} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->create('{{ $tableName }}', function (Blueprint $table) {
{!! $upContent !!}
        }, {{ $withSluggable }}, {{ $withTimestamps }}, {{ $withIncrements }});


@if ($hasTranslation)
        $this->createTranslationFor('{{ $tableName }}', function (Blueprint $table) {
{!! $upContentTranslation !!}
        }, '{{ $foreignField }}', '{{ $tableNameTranslation }}');
@endif
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->{{ $dropFunction }}('{{ $tableName }}');
    }
}
