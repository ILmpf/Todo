<?php

use App\Models\Task;
use App\Models\User;
use App\TaskPriority;
use App\TaskStatus;

test('it belongs to a user', function () {
    $task = Task::factory()->create();

    expect($task->user)->toBeInstanceOf(User::class);
});

test('default status is pending', function () {
    $task = Task::factory()->create();

    // Factory randomises status, but the model default is PENDING
    expect($task->status)->toBeInstanceOf(TaskStatus::class);
});

test('pending factory state sets status correctly', function () {
    $task = Task::factory()->pending()->create();

    expect($task->status)->toBe(TaskStatus::PENDING)
        ->and($task->completed_at)->toBeNull();
});

test('completed factory state sets completed_at', function () {
    $task = Task::factory()->completed()->create();

    expect($task->status)->toBe(TaskStatus::COMPLETED)
        ->and($task->completed_at)->not->toBeNull();
});

test('task status labels are correct', function () {
    expect(TaskStatus::PENDING->label())->toBe('Pendente')
        ->and(TaskStatus::IN_PROGRESS->label())->toBe('Em progresso')
        ->and(TaskStatus::COMPLETED->label())->toBe('Concluída');
});

test('task priority labels are correct', function () {
    expect(TaskPriority::LOW->label())->toBe('Baixa')
        ->and(TaskPriority::MEDIUM->label())->toBe('Média')
        ->and(TaskPriority::HIGH->label())->toBe('Alta');
});

test('soft delete does not permanently remove task', function () {
    $task = Task::factory()->create();
    $id = $task->id;

    $task->delete();

    expect(Task::find($id))->toBeNull();
    expect(Task::withTrashed()->find($id))->not->toBeNull();
});
