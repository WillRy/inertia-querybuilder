<?php

namespace App\Http\Requests;

use App\Rules\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PlanStoreUpdateRequest extends FormRequest
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
        $id = Route::current()->parameter("id") ?? Route::current()->parameter("plan");

        return [
            "name" => ["required", "min:3", "max:255", new UniqueTenant("students", "id", $id, "Nome")],
            "price" => ["required"],
            "duration" => "required|integer"
        ];
    }
}
