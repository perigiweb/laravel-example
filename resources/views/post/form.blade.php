@extends('layouts.app')

@section('content')
    <div class="d-flex gap-2 align-items-center mb-3">
        <a href="{{ route('post.index') }}" class="fs-4"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l4 4" /><path d="M5 12l4 -4" /></svg></a>
        <h1 class="fs-4 mb-0">{{ $pageTitle }}</h1>
    </div>
    <div class="alert @if (session()->has('message')) d-block mb-3 alert-{{ session('message.type') }} @else d-none @endif" id="message">{{ session('message.text') }}</div>
    <form action="{{ $post->exists ? route('post.update', ['post' => $post]):route('post.store') }}" method="POST" class="need-validation" novalidate>
        @if ($post->exists)
            <input type="hidden" name="_method" value="patch">
        @endif
        @csrf
        <div id="message" class="alert py-2 lh-sm @error('message') alert-danger @else d-none @enderror">@error('message'){{ $message }}@enderror</div>
        <div class="mb-3">
            <input required type="text" id="title" name="title" placeholder="Post Title"
                class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}">
            <div class="invalid-feedback">@error('title'){{ $message }} @else Post title is required. @enderror</div>
        </div>
        <div class="mb-3">
            <textarea name="content" id="post-content" rows="6" class="form-control @error('content') is-invalid @enderror"
                required
            >{{ old('content', $post->content) }}</textarea>
            <div class="invalid-feedback">@error('content'){{ $message }} @else Post content is required. @enderror</div>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.0.0/tinymce.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            tinyMCE.init({
                selector: '#post-content',
                plugins: ['link', 'image', 'charmap', 'media'],
                toolbar: 'blocks bold italic underline strikethrough | alignleft aligncenter alignjustify alignright | link image media charmap',
                menubar: false,
                height: '400px',
                image_uploadtab: false,
                image_class_list: [
                    { title: 'Image Fluid', value: 'img-fluid' },
                    { title: 'Image Thumbnail', value: 'img-thumbnail' }
                ],
                iframe_template_callback: data => {
                    return `<div class="ratio ratio-16x9 mb-3"><iframe title="${data.title||''}" width="${data.width||'100%'}" height="${data.height||'100%'}" src="${data.source}"></iframe></div>`
                },
                video_template_callback: data => {
                    return `<div class="ratio ratio-16x9 mb-3"><video width="100%" height="100%"${data.poster ? ` poster="${data.poster}"` : ''} controls="controls">\n` +
                        `<source src="${data.source}"${data.sourcemime ? ` type="${data.sourcemime}"` : ''} />\n` +
                        (data.altsource ? `<source src="${data.altsource}"${data.altsourcemime ? ` type="${data.altsourcemime}"` : ''} />\n` : '') +
                        '</video></div>'
                },
                license_key: 'gpl'
            })
        })
    </script>
@endpush