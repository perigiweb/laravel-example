<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'title' => ['required', 'string', 'min:20', 'max:200'],
            'content' => ['required', 'string', 'min:100']
        ];
    }

    public function createPost()
    {
        $formData = $this->validated();

        $user = $this->user();

        return $user->posts()->create($formData);
    }
}
