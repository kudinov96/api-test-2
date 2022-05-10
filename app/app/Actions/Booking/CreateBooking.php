<?php

namespace App\Actions\Booking;

use App\Http\Requests\BookingCreateRequest;
use App\Models\Booking;

class CreateBooking
{
    public function handle(BookingCreateRequest $request): Booking
    {
        $item             = new Booking();
        $item->car_id     = $request->car_id;
        $item->user_id    = $request->user_id;
        $item->date_start = $request->date_start;
        $item->date_end   = $request->date_end;

        $item->save();

        return $item;
    }
}
