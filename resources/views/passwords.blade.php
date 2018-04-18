@extends('app')

@section('title', 'Passwort Generator')

@section('content')
    <h2>Liste von Passwörtern</h2>

    <ul>
        @foreach ($passwords as $password)
            <li><code>{!! $password !!}</code></li>
        @endforeach
    </ul>
@endsection
