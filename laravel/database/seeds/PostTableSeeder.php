<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Post::class, 50)->create();


        //Seed the post_tags table
        foreach(range(1, 50) as $index)
        {
            DB::table('post_tags')->insert([
                'post_id' => random_int(
                    \DB::table('posts')
                        ->min('id'),
                    \DB::table('posts')
                        ->max('id')),
                'tag_id' => random_int(
                    \DB::table('tags')
                        ->min('id'),
                    \DB::table('tags')
                        ->max('id'))
            ]);
        }
    }
}
