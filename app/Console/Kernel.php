<?php

namespace App\Console;

use App\Jobs\Check_RFID;
use App\Jobs\Nine_Am_Attendance_Check;
use App\Jobs\Update_Bus_Lat_Long;
use App\Jobs\Read_Bus_Accelerometer_Readings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->job(new Update_Bus_Lat_Long)->everySecond();
        $schedule->job(new Check_RFID)->everyFiveSeconds();
        $schedule->job(new Read_Bus_Accelerometer_Readings)->everyFiveSeconds();
        $schedule->job(new Nine_Am_Attendance_Check)->dailyAt('09:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
