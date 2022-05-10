<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 */
class Car extends Model
{
    use HasFactory;

    protected $table = "cars";

    protected $fillable = [
        "name",
    ];

    public function bookings()
    {
        return $this->belongsTo(Booking::class, "id", "car_id");
    }
}
