<?php

namespace App\Console;

use App\Models\Election;
use \App\Models\Candidate_election;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ArteveldeDbBackup::class,
        Commands\ArteveldeDbDrop::class,
        Commands\ArteveldeDbInit::class,
        Commands\ArteveldeDbReset::class,
        Commands\ArteveldeDbRestore::class,
        Commands\ArteveldeDbUser::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
