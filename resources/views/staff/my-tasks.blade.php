@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app title="My Tasks — Taskify">
    <x-page-header title="My Tasks" description="Tasks assigned to you" />

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
    @endif

    <form method="GET" class="mb-6 flex flex-col gap-3 sm:flex-row">
        <x-search-box name="search" :value="request('search')" placeholder="Search my tasks..." class="flex-1" />
        <x-select name="status" placeholder="All statuses" class="sm:w-48">
            @foreach (config('taskify.task_statuses') as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
            @endforeach
        </x-select>
        <x-button type="submit" variant="secondary">Filter</x-button>
    </form>

    @if ($tasks->count())
        <div class="hidden md:block">
            <x-table>
                <x-slot:header>
                    <tr>
                        <x-table-header>Title</x-table-header>
                        <x-table-header>Project</x-table-header>
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
                        <x-table-cell><x-priority-badge :priority="$task['priority']" /></x-table-cell>
                        <x-table-cell><x-status-badge :status="$task['status']" /></x-table-cell>
                        <x-table-cell>{{ $task['due_date'] ? Carbon::parse($task['due_date'])->format('M j, Y') : '—' }}</x-table-cell>
                        <x-table-cell>
                            <x-button :href="route('tasks.show', $task['id'])" variant="ghost" size="sm">View</x-button>
                        </x-table-cell>
                    </x-table-row>
                @endforeach
            </x-table>
        </div>

        <div class="grid gap-4 md:hidden">
            @foreach ($tasks as $task)
                <a href="{{ route('tasks.show', $task['id']) }}" class="block rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:border-brand-200 transition-colors">
                    <p class="font-semibold text-gray-900">{{ $task['title'] }}</p>
                    <p class="text-sm text-gray-500">{{ $task['project']['name'] ?? '' }}</p>
                    <div class="mt-2 flex gap-2">
                        <x-priority-badge :priority="$task['priority']" />
                        <x-status-badge :status="$task['status']" />
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6"><x-pagination :paginator="$tasks" /></div>
    @else
        <x-empty-state title="No tasks assigned" description="You have no tasks matching your filters." />
    @endif
</x-layouts.app>
