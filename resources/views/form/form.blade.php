@extends('layouts.app')

@section('content')
    <div class="col col-md-10 col-lg-8 mx-auto">
        <div class="d-flex gap-2 align-items-center mb-3">
            <a href="{{ route('form.index') }}" class="fs-4"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg></a>
            <h1 class="fs-4 mb-0">{{ $pageTitle }}</h1>
        </div>
        <form action="{{ $form->exists ? route('form.update', ['form' => $form]):route('form.store') }}" method="POST" class="need-validation" novalidate>
            @if ($form->exists)
                <input type="hidden" name="_method" value="patch">
            @endif
            @csrf
            <div id="message" class="alert py-2 lh-sm @error('message') alert-danger @else d-none @enderror">@error('message'){{ $message }}@enderror</div>

            <div class="mb-3">
                <input required type="text" id="title" name="title" placeholder="Form Title"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $form->title) }}">
                <div class="invalid-feedback">@error('title'){{ $message }} @else Form title is required. @enderror</div>
            </div>
        </form>
    </div>
@endsection