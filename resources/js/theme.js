export const THEME_STORAGE_KEY = 'taskify_theme';

const LEGACY_GUEST_THEME_KEY = 'taskify_guest_theme';

export function applyTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
}

export function getStoredTheme(fallback = 'light') {
    try {
        let stored = localStorage.getItem(THEME_STORAGE_KEY);

        if (stored !== 'light' && stored !== 'dark') {
            stored = localStorage.getItem(LEGACY_GUEST_THEME_KEY);

            if (stored === 'light' || stored === 'dark') {
                localStorage.setItem(THEME_STORAGE_KEY, stored);
                localStorage.removeItem(LEGACY_GUEST_THEME_KEY);
            }
        }

        return stored === 'light' || stored === 'dark' ? stored : fallback;
    } catch {
        return fallback;
    }
}

export function storeTheme(theme) {
    if (theme !== 'light' && theme !== 'dark') {
        return;
    }

    try {
        localStorage.setItem(THEME_STORAGE_KEY, theme);
        localStorage.removeItem(LEGACY_GUEST_THEME_KEY);
    } catch {
        // Theme still applies for the current session.
    }

    applyTheme(theme);
}

export async function persistTheme(theme) {
    storeTheme(theme);

    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (! token) {
        return;
    }

    try {
        await fetch('/profile/theme', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ theme_preference: theme }),
        });
    } catch {
        // Theme still applies locally; preference sync can retry on next visit.
    }
}
