<?php

namespace App\Console;

use App\Jobs\DailyCleaningOfTemporaryExportFiles;
use App\Jobs\RefreshMonthlyViewsInLinkJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new DailyCleaningOfTemporaryExportFiles)->daily();
        $schedule->job(new RefreshMonthlyViewsInLinkJob)->monthly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
