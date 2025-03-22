@extends('layouts.app')

@section('content')
    <div class="col col-sm-8 col-md-6 col-lg-5 mx-auto">
        <div class="d-flex gap-2 align-items-center mb-3">
            <h1 class="fs-4 mb-0">My Profile</h1>
        </div>
        <form action="{{ route('user.update', ['user' => auth()->user()]) }}" method="POST" class="need-validation" novalidate>
            <input type="hidden" name="_method" value="patch">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label mb-1">Email</label>
                <input required type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email) }}">
                <div class="invalid-feedback">
                    @error('email')
                        {{ $message }}
                    @else
                        Email is required and must be valid.
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label mb-1">Password</label>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" value="">
                <div class="invalid-feedback">@error('password'){{ $message }} @else Password is required. @enderror</div>
                <div class="form-text">Fill if you want to change your password.</div>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label mb-1">Name</label>
                <input required type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', auth()->user()->name) }}">
                <div class="invalid-feedback">@error('name'){{ $message }} @else Name is required. @enderror</div>
            </div>
            <button type="submit" class="btn btn-primary btn-full px-5">Update Profile</button>
        </form>
    </div>
@endsection