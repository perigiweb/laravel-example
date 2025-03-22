@extends('layouts.app')

@section('content')
<div class="col col-sm-8 col-md-6 col-lg-5 mx-auto">
    <h1 class="mb-4 fs-3">Register</h1>
    <form action="" method="POST" class="need-validation" novalidate>
        <div id="message" class="alert py-2 lh-sm @error('message') alert-danger @else d-none @enderror">@error('message'){{ $message }}@enderror</div>
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input required type="email" id="email" name="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
            <div class="invalid-feedback">
                @error('email')
                    {{ $message }}
                @else
                    Email is required and must be valid.
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input required type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" value="">
            <div class="invalid-feedback">@error('password'){{ $message }} @else Password is required. @enderror</div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input required type="text" id="name" name="name"
                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            <div class="invalid-feedback">
                @error('name')
                    {{ $message }}
                @else
                    Name is required.
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-full px-5">Register</button>
    </form>
</div>
@endsection