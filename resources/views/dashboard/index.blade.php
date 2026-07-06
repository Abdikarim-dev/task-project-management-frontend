<x-layouts.app>
    <x-slot:title>Dashboard — Taskify</x-slot:title>

    <x-page-header
        title="{{ auth_is_admin() ? 'Dashboard' : 'My Dashboard' }}"
        description="Overview of your projects and tasks"
    />
</x-layouts.app>
