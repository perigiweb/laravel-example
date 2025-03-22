@extends('layouts.app')

@section('content')
    <div class="col col-sm-8 col-md-6 col-lg-5 mx-auto">
        <div class="d-flex gap-2 align-items-center mb-3">
            <a href="{{ route('user.index') }}" class="fs-4"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg></a>
            <h1 class="fs-4 mb-0">{{ $pageTitle }}</h1>
        </div>
        <form action="{{ $user->exists ? route('user.update', ['user' => $user]):route('user.store') }}" method="POST" class="need-validation" novalidate>
            @if ($user->exists)
                <input type="hidden" name="_method" value="patch">
            @endif
            <div id="message" class="alert py-2 lh-sm @error('message') alert-danger @else d-none @enderror">@error('message'){{ $message }}@enderror</div>
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label mb-1">Email</label>
                <input required type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
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
                <input type="password" id="password" name="password" @required( !$user->exists)
                    class="form-control @error('password') is-invalid @enderror" value="">
                <div class="invalid-feedback">@error('password'){{ $message }} @else Password is required. @enderror</div>
                @if ($user->exists)
                    <div class="form-text">Fill if you want to change user password.</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="name" class="form-label mb-1">Name</label>
                <input required type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                <div class="invalid-feedback">@error('name'){{ $message }} @else Name is required. @enderror</div>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_admin" value="1" id="is-admin" @checked(old('is_admin', $user->is_admin))>
                <label class="form-check-label" for="is-admin">Is Admin</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is-active" @checked(old('is_active', $user->is_active))>
                <label class="form-check-label" for="is-active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary btn-full px-5">Save</button>
        </form>
    </div>
@endsection