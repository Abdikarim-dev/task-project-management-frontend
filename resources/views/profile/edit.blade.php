<x-layouts.app title="My Profile — Taskify">
    <div class="flex min-h-[calc(100vh-12rem)] items-center justify-center py-8">
        <div class="w-full max-w-md">
            <div class="overflow-hidden rounded-2xl border border-app bg-surface shadow-xl">
                <div class="bg-gradient-to-br from-brand-600 to-brand-700 px-6 pb-16 pt-8 text-center">
                    <p class="text-sm font-medium text-brand-100">Your Profile</p>
                </div>

                <div class="-mt-12 px-6 pb-8">
                    <div class="flex flex-col items-center text-center">
                        <x-avatar :name="$user['name']" size="xl" class="!h-24 !w-24 !text-2xl ring-4 ring-surface shadow-lg" />

                        @if (! empty($user['role_label']))
                            <div class="mt-4">
                                <x-badge :variant="($user['role'] ?? '') === 'admin' ? 'primary' : 'default'">{{ $user['role_label'] }}</x-badge>
                            </div>
                        @endif
                    </div>

                    <div class="mt-8 space-y-6">
                        <x-input
                            label="Full Name"
                            name="name"
                            :value="$user['name'] ?? ''"
                            disabled
                        />
                        <x-input
                            label="Email"
                            name="email"
                            type="email"
                            :value="$user['email'] ?? ''"
                            disabled
                        />

                        <div class="space-y-3">
                            <p class="text-sm font-medium text-app-primary">Appearance</p>

                            <div class="flex gap-3">
                                <button
                                    type="button"
                                    class="flex flex-1 items-center justify-center gap-2 rounded-xl border px-4 py-3 text-sm font-medium transition-all"
                                    :class="theme === 'light'
                                        ? 'border-brand-500 bg-brand-500/10 text-brand-600 ring-2 ring-brand-500/30 dark:text-brand-400'
                                        : 'border-app bg-surface-raised text-app-secondary hover:bg-surface-hover'"
                                    x-on:click="setTheme('light')"
                                >
                                    <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                    </svg>
                                    Light
                                </button>

                                <button
                                    type="button"
                                    class="flex flex-1 items-center justify-center gap-2 rounded-xl border px-4 py-3 text-sm font-medium transition-all"
                                    :class="theme === 'dark'
                                        ? 'border-brand-500 bg-brand-500/10 text-brand-400 ring-2 ring-brand-500/30'
                                        : 'border-app bg-surface-raised text-app-secondary hover:bg-surface-hover'"
                                    x-on:click="setTheme('dark')"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                    </svg>
                                    Dark
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
