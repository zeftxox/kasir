<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function authenticate(): void
    {
        if (! Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'username' => __('Username atau password salah.'),
            ]);
        }
    }
}
