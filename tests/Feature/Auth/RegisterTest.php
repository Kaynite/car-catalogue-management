<?php

use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

test('user can register', function () {
    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    postJson(route('api.register'), $data)
        ->assertOk()
        ->assertJsonStructure(['user', 'token'])
        ->assertJsonFragment(['email' => $data['email']]);

    assertDatabaseHas(User::class, [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);
});

test('user cannot register with the email twice', function () {
    $user = User::factory()->create();

    $data = [
        'name' => 'John Doe',
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    postJson(route('api.register'), $data)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});
