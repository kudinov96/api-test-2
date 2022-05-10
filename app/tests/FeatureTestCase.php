<?php

namespace Tests;

use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Container::getInstance()->make(Generator::class);
    }

    protected function responseDd(TestResponse $response, ?array $payload = null)
    {
        dd(
            json_encode(
                json_decode($response->baseResponse->getContent()), JSON_PRETTY_PRINT
            ),
            $payload
        );
    }
}
