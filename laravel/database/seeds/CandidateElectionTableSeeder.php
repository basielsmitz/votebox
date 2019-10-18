<?php

use Illuminate\Database\Seeder;

class CandidateElectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Candidate_election::class, 600)->create();
    }
}
