<x-layouts.app title="Entrar">

    <!-- Centered card layout -->
    <div class="flex items-start justify-center pt-8 sm:pt-16">
        <div class="w-full max-w-md">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-warm-900">Bem-vindo de volta</h1>
                <p class="text-warm-500 mt-1 text-sm">Inicia sessão para acederes às tuas tarefas.</p>
            </div>

            <!-- Card -->
            <div class="bg-beige-50 border border-beige-200 rounded-2xl shadow-sm p-8">

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div role="alert" aria-live="assertive" class="mb-6 bg-red-50 border border-red-200 rounded-lg px-4 py-3">
                        <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-warm-700 mb-1.5">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full rounded-lg border @error('email') border-red-400 bg-red-50 @else border-beige-300 bg-white @enderror text-warm-900 placeholder-warm-400 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-warm-700 mb-1.5">
                            Palavra-passe
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-lg border @error('password') border-red-400 bg-red-50 @else border-beige-300 bg-white @enderror text-warm-900 placeholder-warm-400 px-3.5 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition"
                        >
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="remember"
                            name="remember"
                            class="rounded border-beige-300 text-accent-600 focus:ring-accent-500 h-4 w-4"
                        >
                        <label for="remember" class="text-sm text-warm-600 select-none cursor-pointer">
                            Manter sessão iniciada
                        </label>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        class="w-full bg-accent-600 hover:bg-accent-700 active:bg-accent-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors shadow-sm text-sm"
                    >
                        Entrar
                    </button>
                </form>

            </div>

            <!-- Register link -->
            <p class="text-center mt-6 text-sm text-warm-500">
                Não tens conta?
                <a href="{{ route('register') }}" class="font-semibold text-accent-600 hover:text-accent-700 transition-colors">
                    Cria uma agora
                </a>
            </p>

        </div>
    </div>

</x-layouts.app>
