@props(['title' => null])

@php
    $initialTheme = user_theme();
@endphp

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full {{ $initialTheme === 'dark' ? 'dark' : '' }}"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sign in — '.config('app.name', 'Taskify') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    <x-theme-script :server-theme="$initialTheme" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased">
    <div class="flex min-h-screen bg-canvas">
        {{-- Brand panel (desktop) --}}
        <aside class="relative hidden w-[44%] max-w-xl flex-col justify-between overflow-hidden border-r border-app bg-surface p-12 lg:flex xl:p-16">
            <div class="auth-grid pointer-events-none absolute inset-0 opacity-60" aria-hidden="true"></div>

            <div class="relative">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 shadow-sm">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold tracking-tight text-app-primary">Taskify</span>
                </div>
            </div>

            <div class="relative space-y-8">
                <div class="space-y-4">
                    <h1 class="text-3xl font-semibold leading-tight tracking-tight text-app-primary xl:text-4xl">
                        Project delivery,<br>without the chaos.
                    </h1>
                    <p class="max-w-sm text-base leading-relaxed text-app-secondary">
                        Coordinate teams, track milestones, and ship work across your organisation — from one calm workspace.
                    </p>
                </div>

                <ul class="space-y-4" role="list">
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </span>
                        <span class="text-sm leading-relaxed text-app-secondary">Role-based dashboards for admins and staff</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </span>
                        <span class="text-sm leading-relaxed text-app-secondary">Projects, tasks, and team visibility in one place</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-500/10 text-brand-600 dark:text-brand-400">
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </span>
                        <span class="text-sm leading-relaxed text-app-secondary">Light and dark modes that follow your preference</span>
                    </li>
                </ul>
            </div>

            <p class="relative text-xs text-app-muted">
                &copy; {{ date('Y') }} Taskify. All rights reserved.
            </p>
        </aside>

        {{-- Auth form panel --}}
        <main class="flex flex-1 flex-col items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="w-full max-w-[400px]">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
