@extends('layouts.app')

@section('content')
    <h1 class="text-center">{{ $post->title }}</h1>
    <div class="mb-4 smal text-center">Written by <b>{{ $post->author->name }}</b> at {{ $post->created_at }}</div>
    {!! $post->content !!}
@endsection