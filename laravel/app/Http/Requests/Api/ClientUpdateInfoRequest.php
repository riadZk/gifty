<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->user('client')->id;

        return [
            'company_name' => ['sometimes', 'string', 'max:255'],
            'contact_name' => ['sometimes', 'string', 'max:255'],
            'email'        => ['sometimes', 'email', 'max:255', Rule::unique('clients', 'email')->ignore($clientId)],
            'phone'        => ['sometimes', 'string', 'max:30',  Rule::unique('clients', 'phone')->ignore($clientId)],
        ];
    }
}
