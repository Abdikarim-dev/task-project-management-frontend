@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app title="Tasks — Taskify">
    <x-page-header title="Tasks" description="Manage all project tasks">
        <x-slot:actions>
            <x-button href="{{ route('tasks.create') }}" variant="primary">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Task
            </x-button>
        </x-slot:actions>
    </x-page-header>

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
    @endif

    <form method="GET" class="mb-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <x-search-box name="search" :value="request('search')" placeholder="Search tasks..." class="lg:col-span-2" />
        <x-select name="status" placeholder="All statuses">
            @foreach (config('taskify.task_statuses') as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </x-select>
        <x-select name="priority" placeholder="All priorities">
            @foreach (config('taskify.task_priorities') as $value => $label)
                <option value="{{ $value }}" @selected(request('priority') === $value)>{{ $label }}</option>
            @endforeach
        </x-select>
        <x-select name="sort" placeholder="Sort by">
            <option value="latest" @selected(request('sort', 'latest') === 'latest')>Latest</option>
            <option value="title" @selected(request('sort') === 'title')>Title</option>
            <option value="due_date" @selected(request('sort') === 'due_date')>Due Date</option>
            <option value="priority" @selected(request('sort') === 'priority')>Priority</option>
            <option value="status" @selected(request('sort') === 'status')>Status</option>
        </x-select>
        <x-button type="submit" variant="secondary" class="lg:col-span-5 sm:col-span-2">Apply Filters</x-button>
    </form>

    @if ($tasks->count())
        <div class="hidden lg:block">
            <x-table>
                <x-slot:header>
                    <tr>
                        <x-table-header>Title</x-table-header>
                        <x-table-header>Project</x-table-header>
                        <x-table-header>Assigned User</x-table-header>
                        <x-table-header>Priority</x-table-header>
                        <x-table-header>Status</x-table-header>
                        <x-table-header>Due Date</x-table-header>
                        <x-table-header><span class="sr-only">Actions</span></x-table-header>
                    </tr>
                </x-slot:header>
                @foreach ($tasks as $task)
                    <x-table-row>
                        <x-table-cell>
                            <a href="{{ route('tasks.show', $task['id']) }}" class="font-medium text-brand-600 hover:text-brand-700">{{ $task['title'] }}</a>
                        </x-table-cell>
                        <x-table-cell>{{ $task['project']['name'] ?? '—' }}</x-table-cell>
                        <x-table-cell>{{ $task['assignee']['name'] ?? 'Unassigned' }}</x-table-cell>
                        <x-table-cell><x-priority-badge :priority="$task['priority']" /></x-table-cell>
                        <x-table-cell><x-status-badge :status="$task['status']" /></x-table-cell>
                        <x-table-cell>{{ $task['due_date'] ? Carbon::parse($task['due_date'])->format('M j, Y') : '—' }}</x-table-cell>
                        <x-table-cell>
                            <x-dropdown align="right">
                                <x-slot:trigger>
                                    <button type="button" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100" aria-label="Actions">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 14a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" /></svg>
                                    </button>
                                </x-slot:trigger>
                                <x-dropdown-item :href="route('tasks.show', $task['id'])">View</x-dropdown-item>
                                <x-dropdown-item :href="route('tasks.edit', $task['id'])">Edit</x-dropdown-item>
                                <button type="button" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50" x-on:click="$dispatch('open-modal', 'delete-task-{{ $task['id'] }}')">Delete</button>
                            </x-dropdown>
                            <x-delete-confirmation-modal name="delete-task-{{ $task['id'] }}" :action="route('tasks.destroy', $task['id'])" />
                        </x-table-cell>
                    </x-table-row>
                @endforeach
            </x-table>
        </div>

        <div class="grid gap-4 lg:hidden">
            @foreach ($tasks as $task)
                <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                    <a href="{{ route('tasks.show', $task['id']) }}" class="font-semibold text-gray-900">{{ $task['title'] }}</a>
                    <p class="mt-1 text-sm text-gray-500">{{ $task['project']['name'] ?? 'No project' }}</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <x-priority-badge :priority="$task['priority']" />
                        <x-status-badge :status="$task['status']" />
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6"><x-pagination :paginator="$tasks" /></div>
    @else
        <x-empty-state title="No tasks found">
            <x-slot:action>
                <x-button href="{{ route('tasks.create') }}" variant="primary">Create Task</x-button>
            </x-slot:action>
        </x-empty-state>
    @endif
</x-layouts.app>
