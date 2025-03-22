@extends('layouts.app')

@section('content')
<div class="d-flex gap-4 align-items-center lh-1 mb-3">
    <h1 class="fs-4 mb-0">My Form</h1>
    <a href="{{ route('form.create') }}" class="btn btn-outline-primary btn-sm">Create Form</a>
</div>
<div class="alert @if (session()->has('form_message')) d-block mb-3 alert-{{ session('form_message.type') }} @else d-none @endif" id="message">{{ session('form_message.text') }}</div>
<div class="d-flex justify-content-between align-items-center gap-2 mb-2">
    <div>
        <button type="button" class="btn btn-outline-danger btn-sm" form="admin-form" data-bs-toggle="delete-all">Delete</button>
    </div>
</div>
<form name="admin-form" id="admin-form" action="" class="table-responsive p-0 border rounded">
    @csrf
    <table class="table table-light card-table">
        <thead>
            <tr>
                <th style="width: 1%"><input type="checkbox" class="form-check-input" data-bs-toggle="check-all"></th>
                <th>Title</th>
                <th>Created At</th>
                <th style="width: 1%"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($forms as $form)
            <tr>
                <td>
                    <input type="checkbox" class="form-check-input" name="id[]" value="{{ $form->id }}" data-bs-toggle="check-item">
                </td>
                <td><a href="{{ route('form.edit', ['form' => $form]) }}">{{ $form->title }}</a></td>
                <td>{{ $form->created_at }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger border-0 shadow-none p-1 lh-1" data-bs-toggle="delete-item"
                        data-url="{{ route('form.destroy', ['form' => $form]) }}"><svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"
                            style="width:20px; height:auto;"><path stroke="none" d="M0 0h24v24H0z"
                            fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path
                            d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path
                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="4">No item found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</form>
@endsection