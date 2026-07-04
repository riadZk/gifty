<?php

namespace App\Http\Requests\Api;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name'      => ['required', 'string', 'max:255'],
            'contact_name'      => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', Rule::unique('clients', 'email')],
            'phone'             => ['required', 'string', 'max:30',  Rule::unique('clients', 'phone')],
            'pcc_customer_code' => ['nullable', 'string', 'max:60', Rule::unique('clients', 'pcc_customer_code')],
            'password'          => ['required', 'string', 'min:8', 'confirmed'],
            'picture'           => ['nullable', 'image', 'max:2048'],
        ];
    }
}
