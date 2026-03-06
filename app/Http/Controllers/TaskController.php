<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\TaskPriority;
use App\TaskStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $query = $user->tasks()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('sort') && $request->sort === 'due_date') {
            $query->reorder()->orderByRaw('due_date IS NULL, due_date ASC');
        }

        $tasks = $query->paginate(10)->withQueryString();

        $userTasks = $user->tasks();
        $stats = [
            'total' => $userTasks->count(),
            'pending' => $userTasks->clone()->where('status', TaskStatus::PENDING)->count(),
            'in_progress' => $userTasks->clone()->where('status', TaskStatus::IN_PROGRESS)->count(),
            'completed' => $userTasks->clone()->where('status', TaskStatus::COMPLETED)->count(),
        ];

        $statuses = TaskStatus::cases();
        $priorities = TaskPriority::cases();

        return view('tasks.index', ['tasks' => $tasks, 'stats' => $stats, 'statuses' => $statuses, 'priorities' => $priorities]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $priorities = TaskPriority::cases();

        return view('tasks.create', ['priorities' => $priorities]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->tasks()->create($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        $this->authorize('view', $task);

        return view('tasks.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $this->authorize('update', $task);

        $priorities = TaskPriority::cases();
        $statuses = TaskStatus::cases();

        return view('tasks.edit', ['task' => $task, 'priorities' => $priorities, 'statuses' => $statuses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $data = $request->validated();

        // Sync completed_at with status
        if ($data['status'] === TaskStatus::COMPLETED->value && ! $task->completed_at) {
            $data['completed_at'] = now();
        } elseif ($data['status'] !== TaskStatus::COMPLETED->value) {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa eliminada com sucesso!');
    }

    /**
     * Toggle task completion status.
     */
    public function complete(Task $task): RedirectResponse
    {
        $this->authorize('update', $task);
        if ($task->status === TaskStatus::COMPLETED) {
            $task->update([
                'status' => TaskStatus::PENDING,
                'completed_at' => null,
            ]);
            $message = 'Tarefa marcada como pendente.';
        } else {
            $task->update([
                'status' => TaskStatus::COMPLETED,
                'completed_at' => now(),
            ]);
            $message = 'Tarefa concluída!';
        }

        return back()->with('success', $message);
    }
}
