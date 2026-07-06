@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app :title="$project['name'].' — Taskify'">
    <x-page-header :title="$project['name']" :description="$project['client_name']">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Projects', 'url' => route('projects.index')],
                ['label' => $project['name']],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:actions>
            <x-button :href="route('projects.edit', $project['id'])" variant="secondary">Edit</x-button>
            @if ($project['can_delete'] ?? (($project['tasks_count'] ?? count($project['tasks'] ?? [])) === 0))
                <x-button type="button" variant="danger" x-on:click="$dispatch('open-modal', 'delete-project')">Delete</x-button>
            @else
                <span class="text-sm text-app-muted">Remove all tasks before deleting this project.</span>
            @endif
        </x-slot:actions>
    </x-page-header>

    @if ($project['can_delete'] ?? (($project['tasks_count'] ?? count($project['tasks'] ?? [])) === 0))
    <x-delete-confirmation-modal
        name="delete-project"
        :action="route('projects.destroy', $project['id'])"
        message="Delete this project? This cannot be undone."
    />
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-card class="lg:col-span-2">
            <h2 class="mb-4 text-base font-semibold text-gray-900">Project Details</h2>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-gray-500">Status</dt>
                    <dd class="mt-1"><x-status-badge :status="$project['status']" /></dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Tasks</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ $project['tasks_count'] ?? count($project['tasks'] ?? []) }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Start Date</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ Carbon::parse($project['start_date'])->format('M j, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-gray-500">Due Date</dt>
                    <dd class="mt-1 text-sm font-medium text-gray-900">{{ Carbon::parse($project['due_date'])->format('M j, Y') }}</dd>
                </div>
            </dl>
            @if ($project['description'])
                <div class="mt-6 border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <p class="mt-2 text-sm text-gray-700">{{ $project['description'] }}</p>
                </div>
            @endif
        </x-card>

        <x-card>
            <h2 class="mb-4 text-base font-semibold text-gray-900">Team Members</h2>
            @if (! empty($project['team_members']))
                <ul class="space-y-3">
                    @foreach ($project['team_members'] as $member)
                        <li class="flex items-center gap-3">
                            <x-avatar :name="$member['name']" size="sm" />
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $member['name'] }}</p>
                                <p class="text-xs text-gray-500">{{ $member['email'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500">No team members assigned.</p>
            @endif
        </x-card>
    </div>

    @if (! empty($project['tasks']))
        <x-card class="mt-6" :padding="false">
            <x-slot:header>
                <h2 class="px-6 pt-6 text-base font-semibold text-gray-900">Project Tasks</h2>
            </x-slot:header>
            <x-table>
                <x-slot:header>
                    <tr>
                        <x-table-header>Title</x-table-header>
                        <x-table-header>Assignee</x-table-header>
                        <x-table-header>Priority</x-table-header>
                        <x-table-header>Status</x-table-header>
                    </tr>
                </x-slot:header>
                @foreach ($project['tasks'] as $task)
                    <x-table-row>
                        <x-table-cell>
                            <a href="{{ route('tasks.show', $task['id']) }}" class="text-brand-600 hover:text-brand-700">{{ $task['title'] }}</a>
                        </x-table-cell>
                        <x-table-cell>{{ $task['assignee']['name'] ?? 'Unassigned' }}</x-table-cell>
                        <x-table-cell><x-priority-badge :priority="$task['priority']" /></x-table-cell>
                        <x-table-cell><x-status-badge :status="$task['status']" /></x-table-cell>
                    </x-table-row>
                @endforeach
            </x-table>
        </x-card>
    @endif
</x-layouts.app>
