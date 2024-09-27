<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\postJson;

test('user can logout', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('api.logout'))
        ->assertNoContent();

    expect($user->tokens()->count())->toBe(0);
});

test('user cannot logout when not authenticated', function () {
    postJson(route('api.logout'))
        ->assertUnauthorized();
});
