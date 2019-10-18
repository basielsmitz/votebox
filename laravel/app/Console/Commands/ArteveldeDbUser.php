<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class ArteveldeDbUser
 *
 * Use:
 * $ php artisan artevelde:db:user
 *
 * @package App\Console\Commands
 * @author Olivier Parent <olivier.parent@arteveldehs.be>
 * @copyright Copyright © 2017, Artevelde University College Ghent
 */
class ArteveldeDbUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artevelde:db:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a database user based on the configuration';

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
        $dbAdminName = getenv('DB_ADMIN_USERNAME');
        $dbAdminPassword = getenv('DB_ADMIN_PASSWORD');

        // Add database user with all privileges on (nonexistent) database.
        $sql = "GRANT ALL PRIVILEGES ON \`${dbName}\`.* TO '${dbUsername}' IDENTIFIED BY '${dbPassword}'";
        $command = sprintf('mysql --user=%s --password=%s --execute="%s"', $dbAdminName, $dbAdminPassword, $sql);
        exec($command);

        $this->comment("Database user `${dbUsername}` created!");
    }
}