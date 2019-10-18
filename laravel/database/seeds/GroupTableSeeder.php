<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Group::class, 50)->create();


        foreach (DB::table('groups')->get() as $group){
            foreach(range(1, random_int(10,50)) as $index) {
                DB::table('group_users')->insert([
                    'user_id' => random_int(
                        \DB::table('users')
                            ->min('id'),
                        \DB::table('users')
                            ->max('id')),
                    'group_id' => $group->id
                ]);
            }
        }

//        foreach(range(1, 500) as $index) {
//            DB::table('group_users')->insert([
//                'user_id' => random_int(
//                    \DB::table('users')
//                        ->min('id'),
//                    \DB::table('users')
//                        ->max('id')),
//                'group_id' => random_int(
//                    \DB::table('groups')
//                        ->min('id'),
//                    \DB::table('groups')
//                        ->max('id'))
//            ]);
//        }


    }
}
