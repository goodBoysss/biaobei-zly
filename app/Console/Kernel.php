<?php

namespace App\Console;

use App\Console\Commands\Domain\AddDomainCommand;
use App\Console\Commands\Sync\SyncVisitRecordCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //同步跳转访问记录（从redis同步到数据库）
        SyncVisitRecordCommand::class,
        //添加域名
        AddDomainCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //同步跳转访问记录（从redis同步到数据库）
        $schedule->command('sync:visit:record')->everyMinute();
    }
}
