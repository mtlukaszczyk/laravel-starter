<?php declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    #[\Override]
    protected function schedule(Schedule $schedule): void
    {
        /*$schedule->call(function (): void {

        })->everyMinute();*/
    }

    #[\Override]
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
