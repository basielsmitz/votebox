<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class ArteveldeDbInit
 *
 * Use:
 * $ php artisan artevelde:db:init
 *
 * @package App\Console\Commands
 * @author Olivier Parent <olivier.parent@arteveldehs.be>
 * @copyright Copyright © 2017, Artevelde University College Ghent
 */
class ArteveldeDbInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artevelde:db:init {--seed : Run migrations and seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates database user and database, and executes migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        // Get variables from `.env`.
        $dbName = getenv('DB_DATABASE');
        $dbUsername = getenv('DB_USERNAME');
        $dbPassword = getenv('DB_PASSWORD');

        // Create database user and drop database if it already exists.
        $this->callSilent('artevelde:db:user');
        $this->callSilent('artevelde:db:drop');

        // Create database.
        $sql = "CREATE DATABASE IF NOT EXISTS \`${dbName}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        $command = sprintf('mysql --user=%s --password=%s --execute="%s"', $dbUsername, $dbPassword, $sql);
        exec($command);

        // Run migrations.
        if ($this->option('seed')) {
            $this->call('migrate', [
                '--seed' => true,
            ]);
        }

        $this->comment("Database `${dbName}` initialized!");
    }
}