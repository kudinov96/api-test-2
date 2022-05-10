<?php

namespace App\Actions\Booking;

use App\Models\Booking;

class DeleteBooking
{
    public function handle(Booking $item)
    {
        $item->delete();
    }
}
