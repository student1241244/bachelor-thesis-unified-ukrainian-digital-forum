<?php

namespace Packages\Dashboard\App\Console;

use File;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PublishConfigCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:package-publish-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish coniguration files of packages to app config';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    }
}
