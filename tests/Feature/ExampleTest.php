<?php

use App\Models\User;

test('guest is redirected to login', function () {
    $this->get('/')
        ->assertRedirect(route('login'));
});

test('authenticated user can access the task list', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertStatus(200);
});
