<?php

namespace App\Http\Controllers;

use App\Actions\Booking\CreateBooking;
use App\Actions\Booking\DeleteBooking;
use App\Http\Requests\BookingCreateRequest;
use App\Http\Resources\Booking\BookingResource;
use App\Http\Resources\SuccessResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @OA\Post (
     *     path="/api/booking",
     *     tags={"Booking"},
     *     @OA\Parameter(
     *         name="car_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="date_start",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="date_end",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation errors",
     *     )
     * )
     */
    public function create(BookingCreateRequest $request, CreateBooking $action)
    {
        $item = $action->handle($request);

        return new BookingResource($item);
    }

    public function delete(int $id, Request $request, DeleteBooking $action): SuccessResource
    {
        $item = $this->stateItem($id);
        $action->handle($item);

        return new SuccessResource($request);
    }

    private function stateItem(int $id)
    {
        return Booking::findOrFail($id);
    }
}
