<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 600)->create();

        DB::table('users')->insert([
            'username' => 'auredeco',
            'email' => 'auredeco@student.arteveldehs.be',
            'password' => bcrypt('password'),
            'lastLogin' => \Carbon\Carbon::now(),
            'firstname' => 'Aurelio',
            'lastname' => 'Decock',
            'gender' => 'male' ,
            'birthdate' => \Carbon\Carbon::now(),
            'pictureUri' => "https://scontent-bru2-1.xx.fbcdn.net/v/t1.0-9/10171703_10205489338099993_3671056655130634994_n.jpg?oh=76ea9546abf190f017331aa02a477363&oe=59AFD54A",
            'remember_token' => str_random(10),
            'api_token' => str_random(60),
            'created_at' => \Carbon\Carbon::now()
        ]);
    }
}
