@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app title="Projects — Taskify">
    <x-page-header title="Projects" description="Manage all client projects">
        <x-slot:actions>
            <x-button href="{{ route('projects.create') }}" variant="primary">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Project
            </x-button>
        </x-slot:actions>
    </x-page-header>

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
    @endif

    <form method="GET" class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center">
        <x-search-box name="search" :value="request('search')" placeholder="Search projects..." class="flex-1" />
        <x-select name="status" placeholder="All statuses" class="sm:w-48">
            @foreach (config('taskify.project_statuses') as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </x-select>
        <x-button type="submit" variant="secondary">Filter</x-button>
    </form>

    @if ($projects->count())
        <div class="hidden md:block">
            <x-table>
                <x-slot:header>
                    <tr>
                        <x-table-header>Project</x-table-header>
                        <x-table-header>Client</x-table-header>
                        <x-table-header>Status</x-table-header>
                        <x-table-header>Due Date</x-table-header>
                        <x-table-header>Tasks</x-table-header>
                        <x-table-header><span class="sr-only">Actions</span></x-table-header>
                    </tr>
                </x-slot:header>
                @foreach ($projects as $project)
                    <x-table-row>
                        <x-table-cell>
                            <a href="{{ route('projects.show', $project['id']) }}" class="font-medium text-brand-600 hover:text-brand-700">{{ $project['name'] }}</a>
                        </x-table-cell>
                        <x-table-cell>{{ $project['client_name'] }}</x-table-cell>
                        <x-table-cell><x-status-badge :status="$project['status']" /></x-table-cell>
                        <x-table-cell>{{ $project['due_date'] ? Carbon::parse($project['due_date'])->format('M j, Y') : '—' }}</x-table-cell>
                        <x-table-cell>{{ $project['tasks_count'] ?? 0 }}</x-table-cell>
                        <x-table-cell>
                            <x-dropdown align="right">
                                <x-slot:trigger>
                                    <button type="button" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600" aria-label="Actions">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 14a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" /></svg>
                                    </button>
                                </x-slot:trigger>
                                <x-dropdown-item :href="route('projects.show', $project['id'])">View</x-dropdown-item>
                                <x-dropdown-item :href="route('projects.edit', $project['id'])">Edit</x-dropdown-item>
                                @if ($project['can_delete'] ?? (($project['tasks_count'] ?? 0) === 0))
                                    <button type="button" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10" x-on:click="$dispatch('open-modal', 'delete-project-{{ $project['id'] }}')">Delete</button>
                                    <x-delete-confirmation-modal
                                        name="delete-project-{{ $project['id'] }}"
                                        title="Delete project?"
                                        message="Delete this project? This cannot be undone."
                                        :action="route('projects.destroy', $project['id'])"
                                    />
                                @else
                                    <span class="block px-4 py-2 text-xs text-app-muted">Delete unavailable (has tasks)</span>
                                @endif
                            </x-dropdown>
                        </x-table-cell>
                    </x-table-row>
                @endforeach
            </x-table>
        </div>

        <div class="grid gap-4 md:hidden">
            @foreach ($projects as $project)
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <a href="{{ route('projects.show', $project['id']) }}" class="font-semibold text-gray-900">{{ $project['name'] }}</a>
                            <p class="text-sm text-gray-500">{{ $project['client_name'] }}</p>
                        </div>
                        <x-status-badge :status="$project['status']" />
                    </div>
                    <div class="mt-3 flex gap-2">
                        <x-button :href="route('projects.show', $project['id'])" variant="secondary" size="sm">View</x-button>
                        <x-button :href="route('projects.edit', $project['id'])" variant="ghost" size="sm">Edit</x-button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <x-pagination :paginator="$projects" />
        </div>
    @else
        <x-empty-state title="No projects found" description="Create your first project to get started.">
            <x-slot:action>
                <x-button href="{{ route('projects.create') }}" variant="primary">Create Project</x-button>
            </x-slot:action>
        </x-empty-state>
    @endif
</x-layouts.app>
