<?php

namespace Packages\Dashboard\App\Console;

use Illuminate\Console\Command;
use Packages\Dashboard\App\Services\Permission\PermissionService;
use Packages\Dashboard\App\Services\Translation\TranslationService;

class BaseSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'cms:sync-dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        (new PermissionService)->sync();
        (new TranslationService)->sync();
    }
}
