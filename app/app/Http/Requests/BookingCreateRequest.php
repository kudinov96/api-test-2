<?php

namespace App\Http\Requests;

use App\Rules\FreeCarRule;
use App\Rules\FreeUserRule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property integer $car_id
 * @property integer $user_id
 * @property Carbon  $date_start
 * @property Carbon  $date_end
 */
class BookingCreateRequest extends FormRequest
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
            "car_id"     => [
                "required",
                "integer",
                "exists:cars,id",
            ],
            "user_id"    => [
                "required",
                "integer",
                "exists:users,id",
                new FreeUserRule(),
            ],
            "date_start" => "required|date",
            "date_end"   => "required|date",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "errors" => $validator->errors(),
        ], 422));
    }
}
