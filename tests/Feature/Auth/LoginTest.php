<?php

use App\Models\User;

use function Pest\Laravel\postJson;

test('user can login ', function () {
    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'password',
    ];

    postJson(route('api.login'), $data)
        ->assertOk()
        ->assertJsonStructure(['user', 'token'])
        ->assertJsonFragment(['id' => $user->id]);
});

test('user cannot login with invalid credentials', function () {
    $data = [
        'email' => 'invalid@example.com',
        'password' => 'invalidpassword',
    ];

    postJson(route('api.login'), $data)
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});
