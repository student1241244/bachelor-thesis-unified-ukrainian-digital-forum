<?php

namespace App\Console;

use App\Models\Setting;
use App\Mail\RecapEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $frequency = Setting::where('setting_name', 'backup_frequency')->value('setting_status') ?? 'daily';
        Log::info("Backup frequency set to: {$frequency}");
    
        if ($frequency == 'weekly')
        {
            $schedule->command('backup:run')->weekly()->withoutOverlapping();
        } 
        elseif ($frequency == 'daily') 
        {
            $schedule->command('backup:run')->daily()->withoutOverlapping();
        } 
        else 
        {
            $schedule->command('backup:run')->everyMinute()->withoutOverlapping();
        }
    }    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
