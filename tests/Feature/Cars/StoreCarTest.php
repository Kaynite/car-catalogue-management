<?php

use App\Models\Car;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

test('user can store a car', function () {
    Storage::fake('public');

    $data = [
        'make' => 'Car Make',
        'model' => 'Car Model',
        'year' => 2024,
        'description' => 'Car Description',
        'price' => 10000,
        'image' => UploadedFile::fake()->image('car.jpg'),
    ];

    $response = asUser()
        ->postJson(route('api.cars.store'), $data)
        ->assertCreated();

    Storage::assertExists(ltrim($response->json('data.image'), '/storage'));

    assertDatabaseHas(Car::class, [
        ...Arr::except($data, ['image']),
        'image' => ltrim($response->json('data.image'), '/storage'),
        'user_id' => Auth::id(),
    ]);
});

test('user can not store a car with invalid data', function () {
    $data = [
        'make' => '',
        'model' => '',
        'year' => '',
        'price' => '',
        'description' => 'Car Description',
        'image' => UploadedFile::fake()->image('car.jpg'),
    ];

    asUser()
        ->postJson(route('api.cars.store'), $data)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['make', 'model', 'price', 'year']);
});

test('user can not store a car with an invalid image', function () {
    $data = [
        'make' => 'Car Make',
        'model' => 'Car Model',
        'year' => 2024,
        'description' => 'Car Description',
        'price' => 10000,
        'image' => 'image',
    ];

    asUser()
        ->postJson(route('api.cars.store'), $data)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['image']);
});

test('only authenticated users can store a car', function () {
    $data = [
        'make' => 'Car Make',
        'model' => 'Car Model',
        'year' => 2024,
        'description' => 'Car Description',
        'price' => 10000,
        'image' => UploadedFile::fake()->image('car.jpg'),
    ];

    postJson(route('api.cars.store'), $data)
        ->assertUnauthorized();

    expect(Car::count())->toBe(0);
});
