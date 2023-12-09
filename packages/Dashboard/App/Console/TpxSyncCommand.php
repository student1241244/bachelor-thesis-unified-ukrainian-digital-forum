<?php

namespace Packages\Dashboard\App\Console;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Packages\Dashboard\App\Services\Config\ConfigService;

class TpxSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:sync';

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
        $this->call('cms:package-publish-config');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('migrate');

        foreach ((new ConfigService)->getSyncCommands() as $namespace) {
            resolve($namespace)->handle();
        }

        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
    }
}
