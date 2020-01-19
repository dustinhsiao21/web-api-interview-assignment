<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'patient_id' => factory(App\Models\Patient::class),
        'question_id' => factory(App\Models\Question::class),
        'answers' => [$faker->word],
    ];
});
