<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ( !$this->route('user') && $this->routeIs('register.post')) || ($this->route('user') && $this->user()->id == $this->route('user')->id) || $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //$editedUser = User::find($this->route('user'));
        return [
            'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->route('user'))],
            'password' => [
                Rule::requiredIf( !$this->route('user'))
            ],
            'name' => ['required']
        ];
    }

    public function createUser(bool $isActive = false)
    {
        $formData = $this->validated();
        $formData['is_admin'] = (bool) $this->post('is_admin', 0);
        $formData['is_active'] = (bool) $this->post('is_active', $isActive);

        return User::factory()->create($formData);
    }
}
