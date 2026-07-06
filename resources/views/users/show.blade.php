@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app :title="$user['name'].' — Taskify'">
    <x-page-header :title="$user['name']" :description="$user['email']">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Users', 'url' => route('users.index')],
                ['label' => $user['name']],
            ]" />
        </x-slot:breadcrumb>
        <x-slot:actions>
            <x-button href="{{ route('users.index') }}" variant="secondary" size="sm">Back to Users</x-button>
            @if ($user['is_suspended'] ?? false)
                <x-badge variant="danger">Suspended</x-badge>
            @endif
            @if (($user['id'] ?? null) !== (auth_user()['id'] ?? null) || ! ($user['role'] === 'admin'))
                <form method="POST" action="{{ route('users.suspend', $user['id']) }}">
                    @csrf
                    @method('PATCH')
                    <x-button
                        type="submit"
                        :variant="($user['is_suspended'] ?? false) ? 'primary' : 'danger'"
                        size="sm"
                    >
                        {{ ($user['is_suspended'] ?? false) ? 'Reactivate User' : 'Suspend User' }}
                    </x-button>
                </form>
            @endif
        </x-slot:actions>
    </x-page-header>

    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <x-stat-card title="Assigned Tasks" :value="$user['tasks_count'] ?? 0" subtitle="Total tasks" color="blue" />
        <x-stat-card title="Projects" :value="count($user['projects'] ?? [])" subtitle="Worked on" color="purple" />
        <x-stat-card
            title="Status"
            :value="($user['is_suspended'] ?? false) ? 'Suspended' : 'Active'"
            :subtitle="$user['role_label']"
            :color="($user['is_suspended'] ?? false) ? 'red' : 'green'"
        />
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        @php
            $taskStatus = $user['tasks_by_status'] ?? [];
            $taskLabels = array_values(config('taskify.task_statuses'));
            $taskKeys = array_keys(config('taskify.task_statuses'));
            $taskData = array_map(fn ($key) => $taskStatus[$key] ?? 0, $taskKeys);
            $taskColors = ['#94a3b8', '#3b82f6', '#22c55e'];

            $projectStatus = $user['projects_by_status'] ?? [];
            $projectLabels = array_values(config('taskify.project_statuses'));
            $projectKeys = array_keys(config('taskify.project_statuses'));
            $projectData = array_map(fn ($key) => $projectStatus[$key] ?? 0, $projectKeys);
            $projectColors = ['#8b5cf6', '#3b82f6', '#22c55e', '#f59e0b'];
        @endphp

        <x-card>
            <x-slot:header>
                <h2 class="text-base font-semibold text-app-primary">Tasks by Status</h2>
            </x-slot:header>
            @if (array_sum($taskData) > 0)
                <x-donut-chart id="userTasksChart" :labels="$taskLabels" :data="$taskData" :colors="$taskColors" />
            @else
                <x-empty-state title="No tasks" description="This user has no assigned tasks yet." />
            @endif
        </x-card>

        <x-card>
            <x-slot:header>
                <h2 class="text-base font-semibold text-app-primary">Projects by Status</h2>
            </x-slot:header>
            @if (array_sum($projectData) > 0)
                <x-donut-chart id="userProjectsChart" :labels="$projectLabels" :data="$projectData" :colors="$projectColors" />
            @else
                <x-empty-state title="No projects" description="This user is not assigned to any projects yet." />
            @endif
        </x-card>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-12 xl:items-start">
        <x-card class="min-w-0 xl:col-span-4 xl:sticky xl:top-24">
            <div class="flex flex-col items-center text-center sm:flex-row sm:items-start sm:text-left sm:gap-4">
                <x-avatar :name="$user['name']" size="xl" class="shrink-0" />
                <div class="min-w-0">
                    <h2 class="text-xl font-bold text-app-primary">{{ $user['name'] }}</h2>
                    <p class="mt-1 truncate text-sm text-app-secondary">{{ $user['email'] }}</p>
                    <div class="mt-2">
                        <x-badge :variant="$user['role'] === 'admin' ? 'primary' : 'default'">{{ $user['role_label'] }}</x-badge>
                    </div>
                </div>
            </div>

            <dl class="mt-6 grid grid-cols-1 gap-4 border-t border-app-subtle pt-6 sm:grid-cols-2 xl:grid-cols-1">
                @if (! empty($user['job_title']))
                    <div>
                        <dt class="text-sm text-app-muted">Job Title</dt>
                        <dd class="mt-1 text-sm font-medium text-app-primary">{{ $user['job_title'] }}</dd>
                    </div>
                @endif
                @if (! empty($user['phone']))
                    <div>
                        <dt class="text-sm text-app-muted">Phone</dt>
                        <dd class="mt-1 text-sm font-medium text-app-primary">{{ $user['phone'] }}</dd>
                    </div>
                @endif
                <div>
                    <dt class="text-sm text-app-muted">Joined</dt>
                    <dd class="mt-1 text-sm font-medium text-app-primary">{{ Carbon::parse($user['created_at'])->format('F j, Y') }}</dd>
                </div>
                @if (! empty($user['bio']))
                    <div class="sm:col-span-2 xl:col-span-1">
                        <dt class="text-sm text-app-muted">Bio</dt>
                        <dd class="mt-1 text-sm text-app-secondary">{{ $user['bio'] }}</dd>
                    </div>
                @endif
            </dl>
        </x-card>

        <x-card class="min-w-0 xl:col-span-8" :padding="false">
            <x-slot:header>
                <h2 class="text-base font-semibold text-app-primary">Projects</h2>
                <p class="mt-1 text-sm text-app-muted">{{ count($user['projects'] ?? []) }} project(s) assigned</p>
            </x-slot:header>

            @if (count($user['projects'] ?? []))
                <x-table flush>
                    <x-slot:header>
                        <tr>
                            <x-table-header class="w-[34%]">Project</x-table-header>
                            <x-table-header class="w-[30%]">Client</x-table-header>
                            <x-table-header class="w-[18%]">Status</x-table-header>
                            <x-table-header class="w-[18%]">Due Date</x-table-header>
                        </tr>
                    </x-slot:header>
                    @foreach ($user['projects'] as $project)
                        <x-table-row>
                            <x-table-cell class="whitespace-normal">
                                <a href="{{ route('projects.show', $project['id']) }}" class="font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                                    {{ $project['name'] }}
                                </a>
                            </x-table-cell>
                            <x-table-cell class="whitespace-normal text-app-secondary">
                                <span class="line-clamp-2">{{ $project['client_name'] ?? '—' }}</span>
                            </x-table-cell>
                            <x-table-cell>
                                <x-status-badge :status="$project['status']" />
                            </x-table-cell>
                            <x-table-cell>
                                {{ ! empty($project['due_date']) ? Carbon::parse($project['due_date'])->format('M j, Y') : '—' }}
                            </x-table-cell>
                        </x-table-row>
                    @endforeach
                </x-table>
            @else
                <div class="px-6 pb-6">
                    <x-empty-state title="No projects" description="Assign this user to projects from the project edit page." />
                </div>
            @endif
        </x-card>
    </div>
</x-layouts.app>
