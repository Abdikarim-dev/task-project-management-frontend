<x-layouts.guest>
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-brand-600 shadow-lg shadow-brand-600/25">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Welcome to Taskify</h1>
            <p class="mt-2 text-sm text-gray-500">Sign in to manage your projects and tasks</p>
        </div>

        {{-- Login Card --}}
        <div class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
            @if (session('success'))
                <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
            @endif

            <form
                method="POST"
                action="{{ route('login') }}"
                x-data="{ loading: false }"
                x-on:submit="loading = true"
            >
                @csrf

                <div class="space-y-5">
                    <x-input
                        label="Email address"
                        name="email"
                        type="email"
                        :value="old('email')"
                        placeholder="you@company.com"
                        required
                        autofocus
                        autocomplete="email"
                        :error="$errors->first('email')"
                    />

                    <x-input
                        label="Password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                        :error="$errors->first('password')"
                    />

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500"
                            />
                            <span class="text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <x-button
                        type="submit"
                        variant="primary"
                        class="w-full"
                        x-bind:disabled="loading"
                    >
                        <span x-show="!loading">Sign In</span>
                        <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </x-button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-gray-400">
            Demo: admin@example.com / password
        </p>
    </div>
</x-layouts.guest>
