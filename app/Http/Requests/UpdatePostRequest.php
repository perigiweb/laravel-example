<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && (Auth::user()->is_admin || Auth::user()->id == $this->route('post')?->user_id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:20', 'max:200'],
            'content' => ['required', 'string', 'min:100']
        ];
    }

    public function updatePost(): Post|bool
    {
        $post = $this->route('post');

        $formData = $this->safe();

        $post->title   = $formData['title'];
        $post->content = $formData['content'];

        return $post->save() ? $post:false;
    }
}
