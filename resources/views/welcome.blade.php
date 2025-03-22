@extends('layouts.app')

@section('content')
    <div class="text-center bg-white rounded p-3 mb-5">
        <h1>Welcome to <b>{{ config('app.name') }}</b></h1>
        @auth
        <p>You logged in as <b>{{ auth()->user()->name }}</b></p>
        @else
        <p><a href="{{ route('login') }}" class="btn btn-warning px-4">Login</a> or <a href="{{ route('register') }}" class="btn btn-warning px-4">Register</a></p>
        @endauth
    </div>
    <div class="">
        <h2>Latest Posts</h2>
        <x-post-list :posts="$posts"></x-post-list>
    </div>
@endsection