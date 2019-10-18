<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(AdminTableSeeder::class);
         $this->call(VotemanagerTableSeeder::class);
         $this->call(VoterTableSeeder::class);
         $this->call(PartyTableSeeder::class);
         $this->call(CandidateTableSeeder::class);
         $this->call(GroupTableSeeder::class);
         $this->call(ElectionTableSeeder::class);
         $this->call(CandidateElectionTableSeeder::class);
         $this->call(ReferendumTableSeeder::class);
         $this->call(CategoryTableSeeder::class);
         $this->call(VoteTableSeeder::class);
         $this->call(TagTableSeeder::class);
         $this->call(PostTableSeeder::class);
         $this->call(HistoryTableSeeder::class);
    }
}
