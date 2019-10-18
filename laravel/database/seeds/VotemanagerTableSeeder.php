<?php

use Illuminate\Database\Seeder;

class VotemanagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Votemanager::class, 10)->create();

    }
}
