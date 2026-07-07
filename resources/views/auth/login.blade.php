<x-layouts.guest>
    {{-- Mobile logo --}}
    <div class="mb-10 text-center lg:hidden">
        <div class="mx-auto mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600 shadow-sm">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <p class="text-sm font-medium text-app-muted">Taskify</p>
    </div>

    <div class="space-y-2 text-center lg:text-left">
        <h2 class="text-2xl font-semibold tracking-tight text-app-primary">Sign in</h2>
        <p class="text-sm text-app-secondary">Enter your credentials to access your workspace</p>
    </div>

    @if (session('success'))
        <x-alert type="success" class="mt-6">{{ session('success') }}</x-alert>
    @endif

    <div class="mt-8 rounded-2xl border border-app bg-surface p-6 shadow-sm transition-shadow duration-200 sm:p-8">
        <form
            method="POST"
            action="{{ route('login') }}"
            class="space-y-5"
            x-data="{ loading: false }"
            x-on:submit="loading = true"
        >
            @csrf

            <x-input
                label="Email"
                name="email"
                type="email"
                :value="old('email')"
                placeholder="name@company.com"
                required
                autofocus
                autocomplete="email"
                :error="$errors->first('email')"
            />

            <x-input
                label="Password"
                name="password"
                type="password"
                placeholder="••••••••"
                required
                autocomplete="current-password"
                :error="$errors->first('password')"
            />

            <div class="flex items-center justify-between pt-1">
                <label class="group flex cursor-pointer items-center gap-2.5">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-app bg-surface-input text-brand-600 transition-colors focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 focus:ring-offset-[var(--surface)]"
                    />
                    <span class="text-sm text-app-secondary transition-colors group-hover:text-app-primary">Remember me</span>
                </label>
            </div>

            <x-button
                type="submit"
                variant="primary"
                size="lg"
                class="w-full !mt-6"
                x-bind:disabled="loading"
            >
                <span x-show="!loading">Continue</span>
                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                    <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Signing in…
                </span>
            </x-button>
        </form>
    </div>

    <div class="mt-8 rounded-xl border border-dashed border-app bg-surface-raised/50 px-4 py-3.5">
        <p class="text-center text-xs font-medium uppercase tracking-wider text-app-muted">Demo accounts</p>
        <div class="mt-3 space-y-2 text-center text-sm text-app-secondary">
            <p>
                <span class="font-medium text-app-primary">Admin</span>
                <span class="mx-1.5 text-app-muted" aria-hidden="true">·</span>
                <code class="rounded-md bg-surface px-1.5 py-0.5 font-mono text-xs text-app-primary">admin@aleelo.org</code>
            </p>
            <p>
                <span class="font-medium text-app-primary">Staff</span>
                <span class="mx-1.5 text-app-muted" aria-hidden="true">·</span>
                <code class="rounded-md bg-surface px-1.5 py-0.5 font-mono text-xs text-app-primary">staff@aleelo.org</code>
            </p>
            <p class="text-xs text-app-muted">Password for both: <code class="font-mono">password</code></p>
        </div>
    </div>
</x-layouts.guest>
