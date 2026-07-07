@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app :title="$task['title'].' — Taskify'">
    <x-page-header :title="$task['title']" :description="$task['project']['name'] ?? ''">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => auth_is_admin() ? 'Tasks' : 'My Tasks', 'url' => auth_is_admin() ? route('tasks.index') : route('tasks.my')],
                ['label' => $task['title']],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:actions>
            @if (auth_is_admin())
                <x-button :href="route('tasks.edit', $task['id'])" variant="secondary">Edit</x-button>
                <x-button type="button" variant="danger" x-on:click="$dispatch('open-modal', 'delete-task')">Delete</x-button>
            @endif
        </x-slot:actions>
    </x-page-header>

    @if (auth_is_admin())
        <x-delete-confirmation-modal name="delete-task" :action="route('tasks.destroy', $task['id'])" />
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <h2 class="mb-4 text-base font-semibold text-app-primary">Task Details</h2>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-app-secondary">Project</dt>
                    <dd class="mt-1 text-sm font-medium text-app-primary">{{ $task['project']['name'] ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-app-secondary">Assigned To</dt>
                    <dd class="mt-1 text-sm font-medium text-app-primary">{{ $task['assignee']['name'] ?? 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-app-secondary">Priority</dt>
                    <dd class="mt-1"><x-priority-badge :priority="$task['priority']" /></dd>
                </div>
                <div>
                    <dt class="text-sm text-app-secondary">Status</dt>
                    <dd class="mt-1"><x-status-badge :status="$task['status']" /></dd>
                </div>
                <div>
                    <dt class="text-sm text-app-secondary">Due Date</dt>
                    <dd class="mt-1 text-sm font-medium text-app-primary">{{ $task['due_date'] ? Carbon::parse($task['due_date'])->format('M j, Y') : '—' }}</dd>
                </div>
            </dl>
            @if ($task['description'])
                <div class="mt-6 border-t border-app-subtle pt-6">
                    <h3 class="text-sm font-medium text-app-secondary">Description</h3>
                    <p class="mt-2 text-sm leading-relaxed text-app-secondary">{{ $task['description'] }}</p>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-base font-semibold text-app-primary">Update Status</h2>
            <form method="POST" action="{{ route('tasks.update-status', $task['id']) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <x-select name="status" label="Status">
                    @foreach (config('taskify.task_statuses') as $value => $label)
                        <option value="{{ $value }}" @selected($task['status'] === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
                <x-button type="submit" variant="primary" class="w-full">Update Status</x-button>
            </form>
        </x-card>
    </div>
</x-layouts.app>
