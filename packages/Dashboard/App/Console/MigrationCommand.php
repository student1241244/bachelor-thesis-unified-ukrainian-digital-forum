<?php

namespace Packages\Dashboard\App\Console;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:migration {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        file_put_contents(
            base_path('database/migrations/') . $this->getFileNameFromName($name),
            view()->file($this->getViewFile(), [
                'name' => $name,
                'table' => $this->getTableNameFromName($name),
            ])->render()
        );
    }

    /**
     * @return string
     */
    public function getViewFile(): string
    {
        return __DIR__ . '/../../views/migration.blade.php';
    }

    /**
     * @param string $name
     * @return string
     */
    public function getTableNameFromName(string $name): string
    {
        $tableName = str_replace(['Create', 'Table'], '', $name);
        $tableName = Str::snake($tableName);
        return $tableName;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getFileNameFromName(string $name): string
    {
        return date('Y_m_d_His_')  . Str::snake($name) . '.php';
    }
}
