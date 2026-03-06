<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Tarefas' }} — Todo App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-beige-100 font-sans antialiased flex flex-col">

    <!-- Navigation -->
    <nav class="bg-beige-50 border-b border-beige-200 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('tasks.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-8 h-8 bg-accent-600 group-hover:bg-accent-700 rounded-lg flex items-center justify-center transition-colors">
                        <svg class="w-4.5 h-4.5 text-white" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-warm-900 tracking-tight">Todo App</span>
                </a>

                <div class="flex items-center gap-3">

                    @auth
                        <div class="flex items-center gap-2 pl-3 border-l border-beige-200">
                            <span class="hidden sm:block text-sm font-medium text-warm-700 max-w-32 truncate">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" title="Sair" aria-label="Sair"
                                        class="inline-flex items-center gap-1 text-warm-500 hover:text-red-600 text-sm font-medium transition-colors">
                                    <svg class="w-4.5 h-4.5" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="hidden sm:inline">Sair</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-warm-600 hover:text-accent-600 transition-colors">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors shadow-sm">
                            Registar
                        </a>
                    @endauth

                </div>

            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div id="flash-message" role="status" aria-live="polite" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="document.getElementById('flash-message').remove()" aria-label="Fechar" class="text-emerald-500 hover:text-emerald-700 flex-shrink-0">
                    <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-error" role="alert" aria-live="assertive" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-red-500 flex-shrink-0" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button onclick="document.getElementById('flash-error').remove()" aria-label="Fechar" class="text-red-500 hover:text-red-700 flex-shrink-0">
                    <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <p class="text-center text-xs text-warm-400">Todo App &copy; {{ date('Y') }}</p>
    </footer>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) flash.style.transition = 'opacity 0.5s', flash.style.opacity = '0', setTimeout(() => flash.remove(), 500);
        }, 4000);
    </script>

</body>
</html>
