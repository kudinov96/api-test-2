<?php

namespace App\Http\Requests;

use App\Rules\FreeCarRule;
use App\Rules\FreeUserRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

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
                new FreeCarRule($this->car_id, $this->date_start, $this->date_end),
            ],
            "user_id"    => [
                "required",
                "integer",
                "exists:users,id",
                new FreeUserRule($this->user_id, $this->date_start, $this->date_end),
            ],
            "date_start" => "required|date",
            "date_end"   => "required|date",
        ];
    }
}
