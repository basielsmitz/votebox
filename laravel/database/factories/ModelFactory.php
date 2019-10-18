<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'lastLogin' => $faker->dateTimeThisMonth,
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'gender' => $faker->randomElement($array = array ('male','female', 'not applicable')) ,
        'birthdate' => $faker->dateTimeThisCentury,
        'pictureUri' => $faker->imageUrl(640, 840, 'people'),
        'remember_token' => str_random(10),
        'api_token' => str_random(60),
        'created_at' => $faker->dateTimeBetween($startDate = '-5 months', $endDate = 'now')
    ];
});
$factory->define(App\Models\Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
    ];
});
$factory->define(App\Models\Votemanager::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
    ];
});
$factory->define(App\Models\Voter::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
$factory->define(App\Models\Party::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'pictureUri' => $faker->imageUrl(640, 840, 'animals')
    ];
});
$factory->define(App\Models\Candidate::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },

        'party_id' => random_int(
            \DB::table('parties')
                ->min('id'),
            \DB::table('parties')
                ->max('id')),
    ];

});
$factory->define(App\Models\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'pictureUri' => $faker->imageUrl(640, 840, 'abstract')
    ];
});
$factory->define(App\Models\Election::class, function (Faker\Generator $faker) {
    $startDate = $faker->dateTimeThisYear;
    $endDate = $faker->dateTimeBetween($startDate, "+1 month");
    $currentState = false;
    if($endDate > date('Y-m-d H:i:s') && $startDate < date('Y-m-d H:i:s')){
        $currentState = true;
    }

    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'isClosed' => true,
        'isComing' => false,
        'pictureUri' => $faker->imageUrl(640, 840, 'business'),
        'group_id' => random_int(
            \DB::table('groups')
                ->min('id'),
            \DB::table('groups')
                ->max('id')),

        'votemanager_id' => random_int(
            \DB::table('votemanagers')
                ->min('id'),
            \DB::table('votemanagers')
                ->max('id')),
    ];
});
$factory->define(App\Models\Candidate_election::class, function (Faker\Generator $faker) {
    return [
        'score' =>  mt_rand(200.00, 5000.00),
        'approved' => true,

        //todo proper foreign keys
        'election_id' => random_int(
            \DB::table('elections')
                ->min('id'),
            \DB::table('elections')
                ->max('id')),
        'candidate_id' => random_int(
            \DB::table('candidates')
                ->min('id'),
            \DB::table('candidates')
                ->max('id')),
    ];
});
$factory->define(App\Models\Referendum::class, function (Faker\Generator $faker) {
    $startDate = $faker->dateTimeThisYear;
    $endDate = $faker->dateTimeBetween($startDate, "+1 month");
        if (rand(0,100) <= 50) {
            $publsihed = $faker->dateTimeThisYear;
        }
        else{
            $publsihed = null;
        }
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'description' => $faker->sentence($nbWords = 12, $variableNbWords = true),
        'startDate' => $startDate,
        'endDate' => $endDate,
        'published' => $faker->dateTimeThisYear,
        'isClosed' => true,

        'candidate_id' => random_int(
            \DB::table('candidates')
                ->min('id'),
            \DB::table('candidates')
                ->max('id')),

        'group_id' => random_int(
            \DB::table('groups')
                ->min('id'),
            \DB::table('groups')
                ->max('id')),

        'votemanager_id' => random_int(
            \DB::table('votemanagers')
                ->min('id'),
            \DB::table('votemanagers')
                ->max('id')),

    ];
});
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Models\Vote::class, function (Faker\Generator $faker) {
    $votetype = $faker->boolean(50);

    if($votetype){
        return [
            'uuid' => str_random(36),
            'checksum' => hash('sha512', 'password'),
            'voteType' => $votetype,
            'agreed' => $faker->boolean(50),
            'uuid' => str_random(36),

            //todo proper foreign keys

            'CandidateElection_id' =>  null,
            'Referendum_id' => random_int(
                \DB::table('referendums')
                    ->min('id'),
                \DB::table('referendums')
                    ->max('id')),
        ];

    }
    else{
        return [
            'uuid' => str_random(36),
            'checksum' => hash('sha512', $faker->password()),
            'voteType' => $votetype,
            'agreed' => null,
            'uuid' => str_random(36),

            //todo proper foreign keys
            'Referendum_id' => null,
            'CandidateElection_id' => random_int(
                \DB::table('candidate_elections')
                    ->min('id'),
                \DB::table('candidate_elections')
                    ->max('id')),
        ];
    }

});
$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});
$factory->define(App\Models\History::class, function (Faker\Generator $faker) {

    if (rand(0,100) <= 50) {
        $referendum = random_int(
            \DB::table('referendums')
                ->min('id'),
            \DB::table('referendums')
                ->max('id'));
        $election = null;
    }
    else{
        $election = random_int(
            \DB::table('elections')
                ->min('id'),
            \DB::table('elections')
                ->max('id'));
        $referendum = null;
    }
    return [
        'user_id' => random_int(
            \DB::table('users')
                ->min('id'),
            \DB::table('users')
                ->max('id')),
        'referendum_id' => $referendum,
        'election_id' => $election,
    ];
});
$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->sentence,

        'user_id' => random_int(
            \DB::table('users')
                ->min('id'),
            \DB::table('users')
                ->max('id')),

        'group_id' => random_int(
            \DB::table('groups')
                ->min('id'),
            \DB::table('groups')
                ->max('id')),

        'category_id' => random_int(
            \DB::table('categories')
                ->min('id'),
            \DB::table('categories')
                ->max('id')),
    ];
});