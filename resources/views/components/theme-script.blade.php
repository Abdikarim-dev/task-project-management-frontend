@props([
    'serverTheme' => 'light',
])

<script>
    (function () {
        var serverTheme = @json($serverTheme);

        try {
            var stored = localStorage.getItem('taskify_theme') || localStorage.getItem('taskify_guest_theme');
            var theme = (stored === 'light' || stored === 'dark') ? stored : serverTheme;

            document.documentElement.classList.toggle('dark', theme === 'dark');

            if (stored === 'light' || stored === 'dark') {
                localStorage.setItem('taskify_theme', stored);
                localStorage.removeItem('taskify_guest_theme');
            }
        } catch (e) {
            document.documentElement.classList.toggle('dark', serverTheme === 'dark');
        }
    })();
</script>
