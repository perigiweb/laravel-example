@extends('layouts.app')

@section('content')
    <h1>{{ $pageTitle }}</h1>

    <div class="alert @if (session()->has('message')) d-block mb-3 alert-{{ session('message.type') }} @else d-none @endif" id="message">{{ session('message.text') }}</div>

    <x-post-list :posts="$posts"></x-post-list>
@endsection