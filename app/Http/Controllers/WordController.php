<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return view('words', [
            'words' => null,
        ]);
    }

    protected function array_combinations(array $array)
    {
        $results = [[]];

        foreach ($array as $element) {
            foreach ($results as $combination) {
                array_push($results, array_merge([$element], $combination));
            }
        }

        return collect($results);
    }

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function chars(Request $request)
    {
        $chars = $request->input('chars', '');
        if (empty($chars)) {
            abort(400);
        }

        $sorted = preg_split('//u', strtolower($chars), null, PREG_SPLIT_NO_EMPTY);
        sort($sorted);

        $combinations = $this->array_combinations($sorted)
            ->map(function ($chars) {
                sort($chars);
                return implode('', $chars);
            })
            ->filter(function ($chars) {
                return (strlen($chars) > 0);
            });

        $query = app('db')
            ->table('words')
            ->select('word')
            ->where(app('db')->raw('CHAR_LENGTH(CONVERT(word_sorted USING utf8))'), '<=', count($sorted))
            ->whereIn('word_sorted', $combinations);

        $words = $query
            ->pluck('word')
            ->filter(function ($word) use ($sorted) {
                $word = strtolower($word);
                $available = $sorted;

                foreach (preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY) as $char) {
                    if (in_array($char, $available) === false) {
                        return false;
                    }

                    $found = array_search($char, $available);
                    unset($available[$found]);
                }

                return true;
            })
            ->sortBy(function ($word) {
                return mb_strlen($word);
            })
            ->map(function ($word) {
                return $word . ' (' . mb_strlen($word) . ')';
            });

        return view('words', [
            'words' => $words,
            'chars' => $chars,
        ]);
    }
}
