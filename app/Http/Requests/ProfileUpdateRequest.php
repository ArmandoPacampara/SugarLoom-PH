<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Base rules for everyone (Name and Email)
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        // If the user is a customer, require the shipping details
        if ($this->user()->isCustomer()) {
            $rules['phone'] = ['required', 'string', 'max:30'];
            $rules['shipping_address'] = ['required', 'string', 'max:255'];
            $rules['city'] = ['required', 'string', 'max:80', Rule::in(config('sugarloom.metro_manila_cities', []))];
            $rules['postal_code'] = ['required', 'string', 'max:20'];
        } else {
            // If the user is an admin, these fields are optional/nullable
            $rules['phone'] = ['nullable', 'string', 'max:30'];
            $rules['shipping_address'] = ['nullable', 'string', 'max:255'];
            $rules['city'] = ['nullable', 'string', 'max:80'];
            $rules['postal_code'] = ['nullable', 'string', 'max:20'];
        }

        return $rules;
    }
}