<?php

namespace Packages\Dashboard\App\Console;

use Illuminate\Console\Command;
use Packages\Dashboard\App\Services\Media\MediaService;

class MediaTempClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:media-temp-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new MediaService)->clearTemp();

        return Command::SUCCESS;
    }
}
