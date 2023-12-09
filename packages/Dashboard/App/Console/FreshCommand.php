<?php

namespace Packages\Dashboard\App\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:fresh';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');
        Artisan::call('cms:sync');
    }
}
