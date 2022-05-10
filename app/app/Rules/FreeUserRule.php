<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class FreeUserRule implements Rule, DataAwareRule
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
        $user = User::find((int) $this->data["user_id"]);

        if (!$user) return true;

        $count = $user->bookings()
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
        return 'This user has already booked a car.';
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
