<?php

use App\Models\Car;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

test('user can update their car', function () {
    $car = Car::factory()->createOne();

    $data = [
        'make' => 'Updated Car',
        'model' => 'Updated Model',
        'year' => 2024,
        'price' => 100000,
        'description' => 'Updated Description',
    ];

    actingAs($car->user)
        ->putJson(route('api.cars.update', $car), $data)
        ->assertOk();

    assertDatabaseHas(Car::class, [
        'id' => $car->id,
        'make' => $data['make'],
        'model' => $data['model'],
        'year' => $data['year'],
        'price' => $data['price'],
        'description' => $data['description'],
    ]);
});

test('user cannot update other cars', function () {
    $car = Car::factory()->createOne();

    $data = [
        'make' => 'Updated Car',
        'model' => 'Updated Model',
        'year' => 2024,
        'price' => 100000,
        'description' => 'Updated Description',
    ];

    asUser()
        ->putJson(route('api.cars.update', $car), $data)
        ->assertNotFound();
});

test('guest cannot update any cars', function () {
    $car = Car::factory()->createOne();

    $data = [
        'make' => 'Updated Car',
        'model' => 'Updated Model',
        'year' => 2024,
        'price' => 100000,
        'description' => 'Updated Description',
    ];

    putJson(route('api.cars.update', $car), $data)
        ->assertUnauthorized();
});

test('user can update their car with image', function () {
    $car = Car::factory()->createOne();

    $data = [
        'make' => 'Updated Car',
        'model' => 'Updated Model',
        'year' => 2024,
        'price' => 100000,
        'description' => 'Updated Description',
        'image' => UploadedFile::fake()->image('updated-image.jpg'),
    ];

    $response = actingAs($car->user)
        ->putJson(route('api.cars.update', $car), $data)
        ->assertOk();

    assertDatabaseHas(Car::class, [
        'id' => $car->id,
        'image' => ltrim($response->json('data.image'), '/storage'),
    ]);

    Storage::assertExists(ltrim($response->json('data.image'), '/storage'));
});
