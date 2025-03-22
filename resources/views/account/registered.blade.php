@extends('layouts.app')

@section('content')
<div class="col col-sm-8 col-md-6 col-lg-5 mx-auto">
    <h1 class="mb-4 fs-3">Registered</h1>
    <p class="alert alert-success">Thanks, you are successfully registered. Now you can <a href="{{ route('login') }}">click here</a> to Login</p>
</div>
@endsection