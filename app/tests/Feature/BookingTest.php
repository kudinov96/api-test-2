<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class BookingTest extends FeatureTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_create()
    {
        list($payload) = $this->createBooking();

        $item = $this->stateByDateStart($payload["date_start"]);

        $this->assertEquals($item->car_id,     $payload["car_id"]);
        $this->assertEquals($item->user_id,    $payload["user_id"]);
        $this->assertEquals($item->date_start, $payload["date_start"]);
        $this->assertEquals($item->date_end,   $payload["date_end"]);
    }

    public function test_create_validate_free_car()
    {
        $car = Car::factory()->create();

        $this->createBooking([
            "car_id"     => $car->id,
            "date_start" => Carbon::create(2022, 1, 1, 12),
            "date_end"   => Carbon::create(2022, 1, 5, 12),
        ]);

        list($payload, $response) = $this->createBooking([
            "car_id"     => $car->id,
            "date_start" => Carbon::create(2022, 1, 2, 12),
            "date_end"   => Carbon::create(2022, 1, 4, 12),
        ]);

        $response->assertJsonFragment(["This car is already booked."]);
    }

    public function test_create_validate_free_user()
    {
        $user = User::factory()->create();

        $this->createBooking([
            "user_id"    => $user->id,
            "date_start" => Carbon::create(2022, 1, 1, 12),
            "date_end"   => Carbon::create(2022, 1, 5, 12),
        ]);

        list($payload, $response) = $this->createBooking([
            "user_id"    => $user->id,
            "date_start" => Carbon::create(2022, 1, 2, 12),
            "date_end"   => Carbon::create(2022, 1, 4, 12),
        ]);

        $response->assertJsonFragment(["This user has already booked a car."]);
    }

    public function test_delete()
    {
        list($payload) = $this->createBooking();
        $item          = $this->stateByDateStart($payload["date_start"]);

        $this->deleteJson("/api/booking/{$item->id}");

        $item = $this->stateByDateStart($payload["date_start"]);
        $this->assertNull($item);
    }

    private function createBooking(array $payload = []): array
    {
        $car  = Car::factory()->create();
        $user = User::factory()->create();

        $payload += [
            "car_id"     => $car->id,
            "user_id"    => $user->id,
            "date_start" => Carbon::create(2022, 1, 1, 12)->toDateTimeString(),
            "date_end"   => Carbon::create(2022, 1, 2, 12)->toDateTimeString(),
        ];

        $response = $this->postJson("/api/booking", $payload);

        return [
            $payload,
            $response,
        ];
    }

    private function stateByDateStart(string $date_start): Booking | null
    {
        return Booking::where("date_start", $date_start)->first();
    }
}
