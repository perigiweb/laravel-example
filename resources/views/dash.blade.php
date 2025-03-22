@extends('layouts.app')

@section('content')
    <h1 class="mb-4 fs-3">Welcome <b>{{ auth()->user()->name }}</b></h1>
@endsection