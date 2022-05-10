<?php

namespace App\Rules;

use App\Models\Car;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class FreeCarRule implements Rule, DataAwareRule
{
    private array $data;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $car = Car::find((int) $this->data["car_id"]);

        if (!$car) return true;

        $count = $car->bookings()
            ->where(function (Builder $query) {
                return $query->whereBetween("date_start", [$this->data["date_start"], $this->data["date_end"]])
                    ->orWhereBetween("date_end", [$this->data["date_start"], $this->data["date_end"]]);
            })->count();

        if ($count > 0) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This car is already booked.';
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
