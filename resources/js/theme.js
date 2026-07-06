export function applyTheme(theme) {
    const isDark = theme === 'dark';
    document.documentElement.classList.toggle('dark', isDark);
}

export async function persistTheme(theme) {
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
