<?php

use Illuminate\Database\Seeder;

class ElectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Election::class, 250)->create();

    }
}
