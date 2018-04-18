<?php

namespace App\Http\Controllers;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
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

        return view('passwords', [
            'passwords' => $passwords
        ]);
    }
}
