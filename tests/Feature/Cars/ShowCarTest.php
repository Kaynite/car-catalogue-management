<?php

use App\Models\Car;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('user can see their car', function () {
    $car = Car::factory()->createOne();

    actingAs($car->user)
        ->getJson(route('api.cars.show', $car))
        ->assertOk()
        ->assertJsonPath('data.id', $car->id);
});

test('user cannot see other cars', function () {
    $car = Car::factory()->createOne();

    asUser()
        ->getJson(route('api.cars.show', $car))
        ->assertNotFound();
});

test('guest cannot see any cars', function () {
    $car = Car::factory()->createOne();

    getJson(route('api.cars.show', $car))
        ->assertUnauthorized();
});
