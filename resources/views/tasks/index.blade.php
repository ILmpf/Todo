<x-layouts.app title="As Minhas Tarefas">

    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-warm-900">As Minhas Tarefas</h1>
            <p class="mt-1 text-sm text-warm-500">Gere e acompanha as tuas tarefas diárias</p>
        </div>
        <a href="{{ route('tasks.create') }}"
           class="inline-flex items-center gap-2 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-sm self-start sm:self-auto">
            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Tarefa
        </a>
    </div>

    <!-- Tasks Overview -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-beige-50 rounded-xl border border-beige-200 p-4">
            <p class="text-xs font-medium text-warm-500 uppercase tracking-wide">Total</p>
            <p class="text-3xl font-bold text-warm-900 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-amber-50 rounded-xl border border-amber-100 p-4">
            <p class="text-xs font-medium text-amber-600 uppercase tracking-wide">Pendentes</p>
            <p class="text-3xl font-bold text-amber-700 mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-blue-50 rounded-xl border border-blue-100 p-4">
            <p class="text-xs font-medium text-blue-600 uppercase tracking-wide">Em Progresso</p>
            <p class="text-3xl font-bold text-blue-700 mt-1">{{ $stats['in_progress'] }}</p>
        </div>
        <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4">
            <p class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Concluídas</p>
            <p class="text-3xl font-bold text-emerald-700 mt-1">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-beige-50 rounded-xl border border-beige-200 p-4 mb-6 shadow-xs">
        <form method="GET" action="{{ route('tasks.index') }}" class="flex flex-col sm:flex-row gap-3">

            <div class="flex-1 relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-warm-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Pesquisar tarefas..."
                    class="w-full rounded-lg border border-beige-200 pl-9 pr-3 py-2 text-sm text-warm-700 placeholder-warm-400 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent bg-beige-50">
            </div>

            <select name="status"
                class="rounded-lg border border-beige-200 px-3 py-2 text-sm text-warm-700 focus:outline-none focus:ring-2 focus:ring-accent-500 bg-beige-50">
                <option value="">Todos os estados</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>

            <select name="priority"
                class="rounded-lg border border-beige-200 px-3 py-2 text-sm text-warm-700 focus:outline-none focus:ring-2 focus:ring-accent-500 bg-beige-50">
                <option value="">Todas as prioridades</option>
                @foreach ($priorities as $priority)
                    <option value="{{ $priority->value }}" {{ request('priority') === $priority->value ? 'selected' : '' }}>
                        {{ $priority->label() }}
                    </option>
                @endforeach
            </select>

            <!-- Sort -->
            <select name="sort"
                class="rounded-lg border border-beige-200 px-3 py-2 text-sm text-warm-700 focus:outline-none focus:ring-2 focus:ring-accent-500 bg-beige-50">
                <option value="">Mais recentes</option>
                <option value="due_date" {{ request('sort') === 'due_date' ? 'selected' : '' }}>Data de vencimento</option>
            </select>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex-1 sm:flex-none bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                    Filtrar
                </button>
                @if (request()->hasAny(['status', 'priority', 'sort', 'search']))
                    <a href="{{ route('tasks.index') }}"
                       class="flex-1 sm:flex-none text-center bg-beige-200 hover:bg-beige-300 text-warm-700 text-sm font-medium px-4 py-2 rounded-lg transition-colors">
                        Limpar
                    </a>
                @endif
            </div>

        </form>

        <!-- Active Filters -->
        @if (request()->hasAny(['status', 'priority', 'sort', 'search']))
            <div class="flex flex-wrap gap-2 mt-3 pt-3 border-t border-beige-200">
                <span class="text-xs text-warm-500 self-center">Filtros activos:</span>
                @if (request('search'))
                    <span class="inline-flex items-center gap-1 bg-accent-50 text-accent-700 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        Pesquisa: &quot;{{ request('search') }}&quot;
                    </span>
                @endif
                @if (request('status'))
                    <span class="inline-flex items-center gap-1 bg-accent-50 text-accent-700 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        Estado: {{ \App\TaskStatus::from(request('status'))->label() }}
                    </span>
                @endif
                @if (request('priority'))
                    <span class="inline-flex items-center gap-1 bg-accent-50 text-accent-700 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        Prioridade: {{ \App\TaskPriority::from(request('priority'))->label() }}
                    </span>
                @endif
                @if (request('sort') === 'due_date')
                    <span class="inline-flex items-center gap-1 bg-accent-50 text-accent-700 rounded-full px-2.5 py-0.5 text-xs font-medium">
                        Ordenado por: Data de vencimento
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Task List -->
    @if ($tasks->isEmpty())
        <div class="text-center py-20">
            <div class="w-16 h-16 bg-beige-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-warm-400" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            @if (request()->hasAny(['status', 'priority', 'sort', 'search']))
                <h3 class="text-base font-semibold text-warm-900 mb-1">Nenhuma tarefa encontrada</h3>
                <p class="text-warm-500 text-sm mb-6">Tenta ajustar os filtros para ver mais resultados.</p>
                <a href="{{ route('tasks.index') }}"
                   class="inline-flex items-center gap-2 bg-beige-200 hover:bg-beige-300 text-warm-700 text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
                    Limpar filtros
                </a>
            @else
                <h3 class="text-base font-semibold text-warm-900 mb-1">Ainda não tens tarefas</h3>
                <p class="text-warm-500 text-sm mb-6">Começa por criar a tua primeira tarefa!</p>
                <a href="{{ route('tasks.create') }}"
                   class="inline-flex items-center gap-2 bg-accent-600 hover:bg-accent-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Criar Tarefa
                </a>
            @endif
        </div>
    @else
        <div class="space-y-2.5">
            @foreach ($tasks as $task)
                @php $isCompleted = $task->status === \App\TaskStatus::COMPLETED; @endphp
                <div class="bg-beige-50 rounded-xl border border-beige-200 overflow-hidden flex hover:border-beige-300 hover:shadow-sm transition-all group {{ $isCompleted ? 'opacity-70' : '' }}">

                    <!-- Priority Stripe -->
                    <div class="w-1 flex-shrink-0 {{ $task->priority->dotClass() }}"></div>

                    <!-- Complete -->
                    <div class="flex items-center pl-4 pr-1">
                        <form method="POST" action="{{ route('tasks.complete', $task) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                title="{{ $isCompleted ? 'Marcar como pendente' : 'Marcar como concluída' }}"
                                aria-label="{{ $isCompleted ? 'Marcar como pendente' : 'Marcar como concluída' }}"
                                aria-pressed="{{ $isCompleted ? 'true' : 'false' }}"
                                class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 transition-all
                                    {{ $isCompleted
                                        ? 'border-emerald-500 bg-emerald-500 text-white'
                                        : 'border-beige-300 hover:border-accent-400 hover:bg-accent-50' }}">
                                @if ($isCompleted)
                                    <svg class="w-3 h-3" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </button>
                        </form>
                    </div>

                    <!-- Task Body -->
                    <div class="flex-1 px-4 py-3 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                            <!-- Title & Description -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="font-semibold text-warm-900 hover:text-accent-600 transition-colors {{ $isCompleted ? 'line-through text-warm-400' : '' }}">
                                    {{ $task->title }}
                                </a>
                                @if ($task->description)
                                    <p class="mt-0.5 text-sm text-warm-500 truncate">{{ $task->description }}</p>
                                @endif
                            </div>

                            <!-- Badges -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $task->priority->badgeClass() }}">
                                    {{ $task->priority->label() }}
                                </span>
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $task->status->badgeClass() }}">
                                    {{ $task->status->label() }}
                                </span>
                            </div>
                        </div>

                        <!-- Footer Row -->
                        <div class="mt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                            <!-- Due Date -->
                            <div class="flex items-center gap-1.5 text-xs text-warm-400">
                                @if ($task->due_date)
                                    @php $isOverdue = $task->due_date->isPast() && ! $isCompleted; @endphp
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 {{ $isOverdue ? 'text-red-400' : '' }}"
                                         aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="{{ $isOverdue ? 'text-red-500 font-semibold' : '' }}">
                                        {{ $isOverdue ? 'Expirou em ' : 'Vence em ' }}{{ $task->due_date->format('d/m/Y') }}
                                    </span>
                                @else
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Sem data de vencimento</span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-0.5">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="text-xs text-warm-500 hover:text-accent-600 font-medium px-2.5 py-1.5 rounded-lg hover:bg-accent-50 transition-colors">
                                    Ver
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}"
                                   class="text-xs text-warm-500 hover:text-accent-600 font-medium px-2.5 py-1.5 rounded-lg hover:bg-accent-50 transition-colors">
                                    Editar
                                </a>
                                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                      onsubmit="return confirm('Tens a certeza que queres eliminar a tarefa \'{{ addslashes($task->title) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-warm-400 hover:text-red-600 font-medium px-2.5 py-1.5 rounded-lg hover:bg-red-50 transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if ($tasks->hasPages())
            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        @endif

        <!-- Showing info -->
        <p class="mt-4 text-center text-xs text-warm-400">
            A mostrar {{ $tasks->firstItem() }}–{{ $tasks->lastItem() }} de {{ $tasks->total() }} tarefa(s)
        </p>
    @endif

</x-layouts.app>
