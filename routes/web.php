<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    $words = app('db')->select('SELECT word FROM words ORDER BY rand() LIMIT 10');

    $passwords = array_map(function ($word) {
        $password = str_replace([
            'o',
            'O',
            'e',
            'E',
            'a',
            'A',
            'l',
            'L',
        ], [
            0,
            0,
            3,
            3,
            4,
            4,
            1,
            1,
        ], $word->word);

        $special = [
            '!',
            '$',
            '%',
            '&',
            '/',
            '(',
            ')',
            '=',
            '+',
            '-',
            '*',
            '.',
            ',',
            ':',
            '-',
            '_',
        ];

        $password = $password . implode('', array_rand(array_flip($special), 2));

        return $password;
    }, $words);

    return view('app', [
        'passwords' => $passwords
    ]);
});
