<?php

use App\Models\Task;
use App\Models\User;
use App\TaskPriority;
use App\TaskStatus;

/* ------------------------------------------------------------------ */
/*  Authentication guard */
/* ------------------------------------------------------------------ */

test('guest cannot access task routes', function () {
    $task = Task::factory()->create();

    $this->get(route('tasks.index'))->assertRedirect(route('login'));
    $this->get(route('tasks.create'))->assertRedirect(route('login'));
    $this->get(route('tasks.show', $task))->assertRedirect(route('login'));
    $this->get(route('tasks.edit', $task))->assertRedirect(route('login'));
});

/* ------------------------------------------------------------------ */
/*  Create */
/* ------------------------------------------------------------------ */

test('authenticated user can create a task', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), [
            'title' => 'Estudar Laravel',
            'priority' => TaskPriority::HIGH->value,
        ])
        ->assertRedirect(route('tasks.index'));

    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'title' => 'Estudar Laravel',
        'priority' => TaskPriority::HIGH->value,
    ]);
});

test('task creation requires a title', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('tasks.store'), ['priority' => TaskPriority::MEDIUM->value])
        ->assertSessionHasErrors('title');
});

/* ------------------------------------------------------------------ */
/*  Read */
/* ------------------------------------------------------------------ */

test('user can see their own tasks listed', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create(['title' => 'Minha tarefa']);

    $this->actingAs($user)
        ->get(route('tasks.index'))
        ->assertStatus(200)
        ->assertSee('Minha tarefa');
});

test('user cannot see another users tasks', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    Task::factory()->for($owner)->create(['title' => 'Tarefa privada']);

    $this->actingAs($other)
        ->get(route('tasks.index'))
        ->assertDontSee('Tarefa privada');
});

test('user can view their own task detail', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    $this->actingAs($user)
        ->get(route('tasks.show', $task))
        ->assertStatus(200)
        ->assertSee($task->title);
});

test('user cannot view another users task', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner)->create();

    $this->actingAs($other)
        ->get(route('tasks.show', $task))
        ->assertForbidden();
});

/* ------------------------------------------------------------------ */
/*  Update */
/* ------------------------------------------------------------------ */

test('user can update their own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->pending()->create();

    $this->actingAs($user)
        ->put(route('tasks.update', $task), [
            'title' => 'Título atualizado',
            'priority' => TaskPriority::LOW->value,
            'status' => TaskStatus::IN_PROGRESS->value,
        ])
        ->assertRedirect(route('tasks.show', $task));

    expect($task->fresh()->title)->toBe('Título atualizado')
        ->and($task->fresh()->status)->toBe(TaskStatus::IN_PROGRESS);
});

test('user cannot update another users task', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner)->create();

    $this->actingAs($other)
        ->put(route('tasks.update', $task), [
            'title' => 'Hackeado',
            'priority' => TaskPriority::LOW->value,
            'status' => TaskStatus::PENDING->value,
        ])
        ->assertForbidden();
});

/* ------------------------------------------------------------------ */
/*  Complete Tasks */
/* ------------------------------------------------------------------ */

test('user can mark their task as completed', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->pending()->create();

    $this->actingAs($user)
        ->patch(route('tasks.complete', $task))
        ->assertRedirect();

    expect($task->fresh()->status)->toBe(TaskStatus::COMPLETED)
        ->and($task->fresh()->completed_at)->not->toBeNull();
});

test('user cannot complete another users task', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner)->pending()->create();

    $this->actingAs($other)
        ->patch(route('tasks.complete', $task))
        ->assertForbidden();
});

/* ------------------------------------------------------------------ */
/*  Delete */
/* ------------------------------------------------------------------ */

test('user can delete their own task', function () {
    $user = User::factory()->create();
    $task = Task::factory()->for($user)->create();

    $this->actingAs($user)
        ->delete(route('tasks.destroy', $task))
        ->assertRedirect(route('tasks.index'));

    $this->assertSoftDeleted('tasks', ['id' => $task->id]);
});

test('user cannot delete another users task', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $task = Task::factory()->for($owner)->create();

    $this->actingAs($other)
        ->delete(route('tasks.destroy', $task))
        ->assertForbidden();
});
