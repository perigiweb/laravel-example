<div class="d-flex flex-column gap-3">
    @foreach ($posts as $post)
    <div class="border-bottom pb-3 position-relative{{ (auth()->user()?->id == $post->user_id || auth()->user()?->is_admin) ? ' pe-5':'' }}">
        <h3 class="fs-6 mb-0"><a href="{{ route('view.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a></h3>
        <div class="small">
            <span>Written by <b>{{ $post->author->name }}</b> at {{ $post->created_at }}</span>
        </div>
        @if (auth()->user()?->id == $post->user_id || auth()->user()?->is_admin)
        <div class="position-absolute top-0 end-0 bottom-0 d-flex justify-content-end flex-nowrap gap-2 bg-body py-1">
            <div><a class="btn btn-outline-primary btn-sm" href="{{ route('post.edit', ['post' => $post]) }}">Edit</a></div>
            <form action="{{ route('post.destroy', ['post' => $post])}}" method="post">
                <input type="hidden" name="_METHOD" value="DELETE">
                @csrf
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="delete-item">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"
                        style="width:20px; height:auto;"><path stroke="none" d="M0 0h24v24H0z"
                        fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path
                        d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path
                        d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                </button>
            </form>
        </div>
        @endif
    </div>
    @endforeach
</div>