<header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-app bg-surface px-4 sm:px-6">
    <button
        type="button"
        class="rounded-lg p-2 text-app-secondary transition-colors hover:bg-surface-hover hover:text-app-primary lg:hidden"
        x-on:click="sidebarOpen = !sidebarOpen"
        aria-label="Toggle sidebar"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <div class="hidden flex-1 sm:block sm:max-w-md">
        <x-search-box placeholder="Search..." class="w-full" />
    </div>

    <div class="flex flex-1 items-center justify-end gap-2 sm:gap-3">
        <button
            type="button"
            class="rounded-lg border border-app p-2 text-app-secondary transition-colors hover:bg-surface-hover hover:text-app-primary"
            x-on:click="toggleTheme()"
            :aria-label="theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'"
        >
            <svg x-show="theme !== 'dark'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
            <svg x-show="theme === 'dark'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
        </button>

        @if ($currentUser)
            <a href="{{ route('profile.edit') }}" class="hidden sm:inline-flex" aria-label="My profile">
                <x-avatar :name="$currentUser['name']" size="sm" />
            </a>
        @endif
    </div>
</header>
