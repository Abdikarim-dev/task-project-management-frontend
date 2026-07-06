@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Taskify') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans" x-data="{ sidebarOpen: false }">
    <div class="flex h-full min-h-screen">
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden"
            x-on:click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transform border-r border-gray-200 bg-white transition-transform duration-200 ease-in-out lg:static lg:translate-x-0"
        >
            <x-layout.sidebar />
        </aside>

        <div class="flex flex-1 flex-col overflow-hidden">
            <x-layout.top-nav />

            <main class="flex-1 overflow-y-auto">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <x-alert type="success" class="mb-6">{{ session('success') }}</x-alert>
                    @endif

                    @if (session('error'))
                        <x-alert type="error" class="mb-6">{{ session('error') }}</x-alert>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <x-layout.footer />
        </div>
    </div>

    @stack('scripts')
</body>
</html>
