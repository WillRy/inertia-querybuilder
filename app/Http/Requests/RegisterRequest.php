<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "company" => "required|min:3|max:255|unique:tenants,name",
            "email" => "required|min:3|max:255|unique:tenants,email|unique:users,email",
            "password" => "required|min:6",
            "name" => "required|min:3|max:255"
        ];
    }
}
