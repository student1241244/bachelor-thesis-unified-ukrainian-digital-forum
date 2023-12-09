<?php

namespace Packages\Dashboard\App\Migrations;

use Closure;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Schema;

class Migration extends BaseMigration
{
    protected $tables = [];

    /**
     * @param string $table
     * @param Closure|null $callback
     * @param bool|bool $sluggable
     * @param bool|bool $withTimestamps
     * @param bool|bool $withIncrements
     * @return $this
     */
    public function create(
        string $table,
        Closure $callback = null,
        bool $sluggable = true,
        bool $withTimestamps = true,
        bool $withIncrements = true
    )
    {
        $this->tables[] = $table;

        Schema::create($table, function (Blueprint $table) use (
            $callback,
            $sluggable,
            $withTimestamps,
            $withIncrements
        ) {
            if ($withIncrements) {
                $table->bigIncrements('id');
            }

            if (!is_null($callback)) {
                $callback($table);
            }

            if ($sluggable) {
                $table->string('slug')->unique()->index();
            }

            if ($withTimestamps) {
                $table->timestamps();
            }
            $table->engine = 'InnoDB';
        });

        return $this;
    }

    public function table($table, Closure $callback = null)
    {
        $this->tables[] = $table;

        if (!is_null($callback)) {
            Schema::table($table, function (Blueprint $table) use ($callback) {
                $callback($table);
            });
        }

        return $this;
    }

    /**
     * @param string $relatedTable
     * @param string|null $foreignKey
     * @param bool|bool $withForeign
     * @param string|null $onDeleteAction
     * @param bool|bool $nullable
     * @return $this
     */
    public function relatedTo(
        string $relatedTable,
        string $foreignKey = null,
        bool $withForeign = true,
        string $onDeleteAction = null,
        bool $nullable = false
    )
    {
        $rootTable = collect($this->tables)->last();

        if (!$rootTable) {
            return $this;
        }

        $foreignKey = $foreignKey ? $foreignKey : str_singular($relatedTable) . '_id';
        $onDeleteAction = $onDeleteAction ? $onDeleteAction : 'CASCADE';

        Schema::table($rootTable, function (Blueprint $table) use (
            $foreignKey,
            $relatedTable,
            $withForeign,
            $onDeleteAction,
            $nullable
        ) {
            if ($nullable) {
                $table->unsignedBigInteger($foreignKey)->nullable();
            } else {
                $table->unsignedBigInteger($foreignKey);
            }

            if($withForeign) {
                $table->foreign($foreignKey)
                    ->references('id')
                    ->on($relatedTable)
                    ->onDelete($onDeleteAction);
            }
        });

        return $this;
    }


    /**
    public function relatedTo($tables = [], $withForeign = true)
    {
        $rootTable = collect($this->tables)->last();

        if (!$rootTable) {
            return $this;
        }

        if (!is_array($tables)) {
            $tables = [$tables];
        }

        foreach ($tables as $relatedTable) {
            $foreignKey = str_singular($relatedTable) . '_id';

            Schema::table($rootTable, function (Blueprint $table) use ($foreignKey, $relatedTable, $withForeign) {
                $table->unsignedBigInteger($foreignKey)->after('id');
                if($withForeign) {
                    $table->foreign($foreignKey)->references('id')->on($relatedTable)->onDelete('cascade');
                }
            });
        }

        return $this;
    }
    */

    public function dropRelations($tables = [])
    {
        $rootTable = collect($this->tables)->last();

        if (!$rootTable) {
            return $this;
        }

        if (!is_array($tables)) {
            $tables = [$tables];
        }

        foreach ($tables as $relatedTable) {
            $foreignKey = str_singular($relatedTable) . '_id';

            Schema::table($rootTable, function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign([$foreignKey]);
                $table->dropColumn($foreignKey);
            });
        }

        return $this;
    }

    public function createTranslationFor($translatedTable, Closure $callback = null, $foreignKey = null, $tableName = null)
    {
        if (is_null($foreignKey)) {
            $foreignKey = str_singular($translatedTable) . '_id';
        }

        $table = $tableName ?: $this->getTranslationTableName($translatedTable);

        $this->tables[] = $table;

        Schema::create($table, function (Blueprint $table) use ($callback, $translatedTable, $foreignKey) {
            $table->increments('id');
            $table->unsignedBigInteger($foreignKey);
            $table->string('locale')->index();

            $table->unique([$foreignKey, 'locale'], $translatedTable . '_tr_unique');
            $table->foreign($foreignKey, Migration::resolveForeignKeyName($foreignKey))->references('id')->on($translatedTable)->onDelete('cascade');

            if (!is_null($callback)) {
                $callback($table);
            }
        });
    }

    /**
     * @param string $name
     * @return string
     */
    public static function resolveForeignKeyName(string $name): string
    {
        $parts = [];
        foreach (explode('_', $name) as $i => $item) {
            $parts[] = $i < 2 ? $item : substr($item, 0, 2);
        }

        return implode('_', $parts) . Str::random(6);
    }

    public function drop($tables)
    {
        if (!is_array($tables)) {
            $tables = [$tables];
        }

        foreach ($tables AS $table) {
            Schema::dropIfExists($table);
        }
    }

    public function dropWithTranslations($tables)
    {
        if (!is_array($tables)) {
            $tables = [$tables];
        }

        foreach ($tables AS $table) {
            Schema::dropIfExists($this->getTranslationTableName($table));
            Schema::dropIfExists($table);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->drop(array_reverse($this->tables));
    }

    private function getTranslationTableName($table)
    {
        return str_singular($table) . '_translations';
    }
}
