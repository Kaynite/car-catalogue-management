<?php

use App\Models\Car;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;

test('user can delete their car', function () {
    $car = Car::factory()->createOne();

    actingAs($car->user)
        ->deleteJson(route('api.cars.destroy', $car))
        ->assertNoContent();
});

test('user cannot delete other cars', function () {
    $car = Car::factory()->createOne();

    asUser()
        ->deleteJson(route('api.cars.destroy', $car))
        ->assertNotFound();

    assertDatabaseHas('cars', ['id' => $car->id]);
});

test('guest cannot delete any cars', function () {
    $car = Car::factory()->createOne();

    getJson(route('api.cars.destroy', $car))
        ->assertUnauthorized();

    assertDatabaseHas('cars', ['id' => $car->id]);
});
