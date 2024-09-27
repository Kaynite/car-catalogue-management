<?php

use App\Models\Car;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

test('user can list his own cars', function () {
    $user = User::factory()
        ->hasCars(3)
        ->createOne();

    actingAs($user)
        ->getJson(route('api.cars.index'))
        ->assertOk()
        ->assertJsonCount(3, 'data');
});

test('user cannot list cars from another user', function () {
    Car::factory(3)->create();

    asUser()
        ->getJson(route('api.cars.index'))
        ->assertOk()
        ->assertJsonCount(0, 'data');
});

test('only authenticated users can list cars', function () {
    Car::factory(3)->create();

    getJson(route('api.cars.index'))
        ->assertUnauthorized();
});
