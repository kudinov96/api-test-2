<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $car_id
 * @property int    $user_id
 * @property string $date_start
 * @property string $date_end
 *
 * @OA\Schema(
 *     title="Booking",
 *     @OA\Xml(
 *         name="Booking"
 *     )
 * )
 */
class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = "booking";

    protected $fillable = [
        "car_id",
        "user_id",
        "date_start",
        "date_end",
    ];

    /**
     * @OA\Property(
     *     title="id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="car_id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $car_id;

    /**
     * @OA\Property(
     *     title="user_id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property(
     *     title="date_start",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     * )
     */
    private $date_start;

    /**
     * @OA\Property(
     *     title="date_end",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     * )
     */
    private $date_end;
}
