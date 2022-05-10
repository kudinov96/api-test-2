<?php

namespace App\Rules;

use App\Models\Car;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class FreeCarRule implements Rule
{
    private Car    $car;
    private string $date_start;
    private string $date_end;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($car_id, $date_start, $date_end)
    {
        if ($car_id !== null) {
            $this->car = Car::find($car_id);
        }

        if ($date_start !== null) {
            $this->date_start = $date_start;
        }

        if ($date_end !== null) {
            $this->date_end = $date_end;
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $count = $this->car->bookings()
            ->where(function (Builder $query) {
                return $query->whereBetween("date_start", [$this->date_start, $this->date_end])
                    ->orWhereBetween("date_end", [$this->date_start, $this->date_end]);
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
}
