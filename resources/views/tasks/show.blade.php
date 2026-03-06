<x-layouts.app title="{{ $task->title }}">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-warm-500 mb-6">
        <a href="{{ route('tasks.index') }}" class="hover:text-accent-600 transition-colors">Tarefas</a>
        <svg class="w-4 h-4 text-warm-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-warm-700 font-medium truncate max-w-xs">{{ $task->title }}</span>
    </nav>

    <div class="max-w-2xl">

        <!-- Task Card -->
        <div class="bg-beige-50 rounded-2xl border border-beige-200 shadow-sm overflow-hidden">

            <!-- Priority Stripe -->
            <div class="h-1.5 w-full {{ $task->priority->dotClass() }}"></div>

            <!-- Header -->
            <div class="px-6 pt-6 pb-5 border-b border-beige-200">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                    <!-- Title & Badges -->
                    <div class="flex-1 min-w-0">
                        <div class="flex  flex-wrap items-center gap-2 mb-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $task->priority->badgeClass() }}">
                                {{ $task->priority->label() }}
                            </span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $task->status->badgeClass() }}">
                                {{ $task->status->label() }}
                            </span>
                        </div>
                        <h1 class="text-xl font-bold text-warm-900 {{ $task->status === \App\TaskStatus::COMPLETED ? 'line-through text-warm-400' : '' }}">
                            {{ $task->title }}
                        </h1>
                    </div>

                    <!-- Complete Toggle -->
                    <form method="POST" action="{{ route('tasks.complete', $task) }}" class="flex-shrink-0">
                        @csrf
                        @method('PATCH')
                        @php $isCompleted = $task->status === \App\TaskStatus::COMPLETED; @endphp
                        <button type="submit"
                            class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-lg border transition-all
                                {{ $isCompleted
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-beige-50 hover:text-warm-600 hover:border-beige-200'
                                    : 'bg-beige-50 text-warm-700 border-beige-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200' }}">
                            @if ($isCompleted)
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Concluída
                            @else
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Marcar como Concluída
                            @endif
                        </button>
                    </form>

                </div>
            </div>

            <!-- Description -->
            @if ($task->description)
                <div class="px-6 py-5 border-b border-beige-200">
                    <h2 class="text-xs font-semibold text-warm-500 uppercase tracking-wide mb-2">Descrição</h2>
                    <p class="text-sm text-warm-700 leading-relaxed whitespace-pre-line">{{ $task->description }}</p>
                </div>
            @else
                <div class="px-6 py-5 border-b border-beige-200">
                    <p class="text-sm text-warm-400 italic">Sem descrição.</p>
                </div>
            @endif

            <!-- Metadata Grid -->
            <div class="px-6 py-5 border-b border-beige-200 grid grid-cols-2 sm:grid-cols-4 gap-5">

                <div>
                    <p class="text-xs font-semibold text-warm-500 uppercase tracking-wide mb-1">Data de Vencimento</p>
                    @if ($task->due_date)
                        @php $isOverdue = $task->due_date->isPast() && $task->status !== \App\TaskStatus::COMPLETED; @endphp
                        <p class="text-sm font-medium {{ $isOverdue ? 'text-red-600' : 'text-warm-900' }}">
                            {{ $task->due_date->format('d/m/Y') }}
                            @if ($isOverdue)
                                <span class="block text-xs font-normal text-red-500">Expirou</span>
                            @endif
                        </p>
                    @else
                        <p class="text-sm text-warm-400">—</p>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold text-warm-500 uppercase tracking-wide mb-1">Criada em</p>
                    <p class="text-sm font-medium text-warm-900">{{ $task->created_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-warm-400">{{ $task->created_at->format('H:i') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-warm-500 uppercase tracking-wide mb-1">Última Atualização</p>
                    <p class="text-sm font-medium text-warm-900">{{ $task->updated_at->format('d/m/Y') }}</p>
                    <p class="text-xs text-warm-400">{{ $task->updated_at->format('H:i') }}</p>
                </div>

                @if ($task->completed_at)
                    <div>
                        <p class="text-xs font-semibold text-warm-500 uppercase tracking-wide mb-1">Concluída em</p>
                        <p class="text-sm font-medium text-emerald-700">{{ $task->completed_at->format('d/m/Y') }}</p>
                        <p class="text-xs text-warm-400">{{ $task->completed_at->format('H:i') }}</p>
                    </div>
                @endif

            </div>

            <!-- Footer Actions -->
            <div class="px-6 py-4 bg-beige-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <a href="{{ route('tasks.index') }}"
                   class="inline-flex items-center gap-1.5 text-sm text-warm-500 hover:text-accent-600 font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Voltar às Tarefas
                </a>

                <div class="flex items-center gap-2">
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="inline-flex items-center gap-1.5 bg-beige-50 hover:bg-beige-200 text-warm-700 text-sm font-medium px-4 py-2 rounded-lg border border-beige-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                          onsubmit="return confirm('Tens a certeza que queres eliminar esta tarefa? Esta ação é irreversível.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 bg-beige-50 hover:bg-red-50 text-red-500 hover:text-red-700 text-sm font-medium px-4 py-2 rounded-lg border border-beige-200 hover:border-red-200 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>

</x-layouts.app>
