<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class FreeUserRule implements Rule
{
    private User   $user;
    private string $date_start;
    private string $date_end;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id, $date_start, $date_end)
    {
        if ($user_id !== null) {
            $this->user = User::find($user_id);
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
        $count = $this->user->bookings()
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
        return 'This user has already booked a car.';
    }
}
