<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterInviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ], 
            'email' => [
                'required',
                'email',
                // 'unique:register_invites'
            ],
            'control_number' => [
                'required',
            ], 
            'title' => [
                'required',
            ], 
            'attending' => [
                'required',
            ],  
            'company' => [
                'required',
            ], 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        session()->flash('message_error', 'Please fill up the form before confirming.');

        parent::failedValidation($validator);
    }
}
