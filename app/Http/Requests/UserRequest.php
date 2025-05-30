<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the user ID from the route (Laravel auto-injects the model)
        $user = $this->route('user');
        return [
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user?->id),
            ],
            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }
}