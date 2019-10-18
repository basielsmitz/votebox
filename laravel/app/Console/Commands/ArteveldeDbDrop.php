<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class ArteveldeDbDrop
 *
 * Use:
 * $ php artisan artevelde:db:drop
 *
 * @package App\Console\Commands
 * @author Olivier Parent <olivier.parent@arteveldehs.be>
 * @copyright Copyright © 2017, Artevelde University College Ghent
 */
class ArteveldeDbDrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artevelde:db:drop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops database';

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
        // Get variables from `.env`
        $dbName = getenv('DB_DATABASE');
        $dbUsername = getenv('DB_USERNAME');
        $dbPassword = getenv('DB_PASSWORD');

        // Drop database
        $sql = "DROP DATABASE IF EXISTS \`${dbName}\`";
        $command = sprintf('mysql --user=%s --password=%s --execute="%s"', $dbUsername, $dbPassword, $sql);
        exec($command);

        $this->comment("Database `${dbName}` dropped!");
    }
}