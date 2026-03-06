<x-layouts.app title="Nova Tarefa">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-warm-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('tasks.index') }}" class="hover:text-accent-600 transition-colors">Tarefas</a>
        <svg class="w-4 h-4 text-warm-300" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-warm-700 font-medium">Nova Tarefa</span>
    </nav>

    <div class="max-w-2xl">

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-warm-900">Nova Tarefa</h1>
            <p class="mt-1 text-sm text-warm-500">Preenche os detalhes da tua nova tarefa abaixo.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-beige-50 rounded-2xl border border-beige-200 shadow-sm overflow-hidden">
            <form method="POST" action="{{ route('tasks.store') }}" class="divide-y divide-beige-200">
                @csrf

                <!-- Title -->
                <div class="px-6 py-5">
                    <label for="title" class="block text-sm font-semibold text-warm-700 mb-1.5">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        autofocus
                        class="w-full rounded-lg border px-3 py-2.5 text-sm text-warm-900 placeholder-warm-400 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent
                            {{ $errors->has('title') ? 'border-red-300 bg-red-50' : 'border-beige-200 bg-beige-50' }}">
                    @error('title')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1" role="alert">
                            <svg class="w-3.5 h-3.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="px-6 py-5">
                    <label for="description" class="block text-sm font-semibold text-warm-700 mb-1.5">
                        Descrição <span class="text-warm-400 font-normal">(opcional)</span>
                    </label>
                    <textarea id="description" name="description" rows="3"
                        placeholder="Adiciona uma descrição ou notas adicionais..."
                        class="w-full rounded-lg border px-3 py-2.5 text-sm text-warm-900 placeholder-warm-400 resize-none transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent
                            {{ $errors->has('description') ? 'border-red-300 bg-red-50' : 'border-beige-200 bg-beige-50' }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority & Due Date Grid -->
                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-semibold text-warm-700 mb-1.5">
                            Prioridade <span class="text-red-500">*</span>
                        </label>
                        <select id="priority" name="priority"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-warm-900 bg-beige-50 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent
                                {{ $errors->has('priority') ? 'border-red-300' : 'border-beige-200' }}">
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority->value }}" {{ old('priority', 'medium') === $priority->value ? 'selected' : '' }}>
                                    {{ $priority->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-semibold text-warm-700 mb-1.5">
                            Data de Vencimento <span class="text-warm-400 font-normal">(opcional)</span>
                        </label>
                        <input type="date" id="due_date" name="due_date"
                            value="{{ old('due_date') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border px-3 py-2.5 text-sm text-warm-900 bg-beige-50 transition-colors focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent
                                {{ $errors->has('due_date') ? 'border-red-300' : 'border-beige-200' }}">
                        @error('due_date')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="px-6 py-4 bg-beige-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                    <a href="{{ route('tasks.index') }}"
                       class="text-center bg-beige-50 hover:bg-beige-200 text-warm-700 text-sm font-medium px-5 py-2.5 rounded-lg border border-beige-200 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition-colors shadow-sm">
                        Criar Tarefa
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-layouts.app>
