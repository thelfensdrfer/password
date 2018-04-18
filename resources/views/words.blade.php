@extends('app')

@section('title', 'Wörter mit Buchstaben')

@section('content')
    <h2>Buchstaben eingeben</h2>

    <form method="post" url="/words">
        <div class="row uniform">
            <div class="6u 12u$(xsmall)">
                <input name="chars" id="chars" value="" placeholder="Buchstaben" type="text">
            </div>
        </div>
    </form>

    @if (isset($words))
        <h2>Wörter mit Buchstaben <code>{{ $chars }}</code></h2>

        <ul>
            @foreach ($words as $word)
                <li><code>{{ $word }}</code></li>
            @endforeach
        </ul>
    @endif
@endsection
