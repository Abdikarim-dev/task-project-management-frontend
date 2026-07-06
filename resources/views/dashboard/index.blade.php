@php
    use Illuminate\Support\Carbon;

    $isAdmin = auth_is_admin();
@endphp

<x-layouts.app title="{{ $isAdmin ? 'Dashboard' : 'My Dashboard' }} — Taskify">

    <x-page-header
        :title="$isAdmin ? 'Dashboard' : 'My Dashboard'"
        description="Overview of your projects and tasks"
    />

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
        <x-empty-state
            title="Unable to load dashboard"
            description="Make sure the backend API is running at {{ config('api.base_url') }}"
        />
    @elseif ($dashboard)
        {{-- Summary stats --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @if ($isAdmin)
                <x-stat-card
                    title="Total Projects"
                    :value="$dashboard['total_projects']"
                    :subtitle="($dashboard['active_projects'] ?? 0).' active'"
                    color="blue"
                >
                    <x-slot:icon>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" /></svg>
                    </x-slot:icon>
                </x-stat-card>
            @else
                <x-stat-card
                    title="Assigned Tasks"
                    :value="$dashboard['total_tasks']"
                    subtitle="Total assigned to you"
                    color="blue"
                >
                    <x-slot:icon>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" /></svg>
                    </x-slot:icon>
                </x-stat-card>
            @endif

            <x-stat-card
                :title="$isAdmin ? 'Active Tasks' : 'Pending Tasks'"
                :value="$dashboard['active_tasks']"
                :subtitle="$isAdmin ? ($dashboard['total_tasks'].' total tasks') : 'Awaiting completion'"
                color="yellow"
            >
                <x-slot:icon>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card
                title="Completed Tasks"
                :value="$dashboard['completed_tasks']"
                :subtitle="$dashboard['total_tasks'] > 0 ? round(($dashboard['completed_tasks'] / $dashboard['total_tasks']) * 100).'% completion rate' : 'No tasks yet'"
                color="green"
            >
                <x-slot:icon>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </x-slot:icon>
            </x-stat-card>

            <x-stat-card
                title="Overdue Tasks"
                :value="$dashboard['overdue_tasks']"
                subtitle="Past due date"
                :trendUp="false"
                color="red"
            >
                <x-slot:icon>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" /></svg>
                </x-slot:icon>
            </x-stat-card>
        </div>

        {{-- Charts --}}
        @php
            $taskStatus = $dashboard['tasks_by_status'] ?? [];
            $taskLabels = ['To Do', 'In Progress', 'Completed'];
            $taskData = [
                $taskStatus['to_do'] ?? 0,
                $taskStatus['in_progress'] ?? 0,
                $taskStatus['completed'] ?? 0,
            ];
            $taskColors = ['#94a3b8', '#3b82f6', '#22c55e'];

            $projectStatus = $dashboard['projects_by_status'] ?? [];
            $projectLabels = ['Planning', 'Active', 'Completed', 'On Hold'];
            $projectData = [
                $projectStatus['planning'] ?? 0,
                $projectStatus['active'] ?? 0,
                $projectStatus['completed'] ?? 0,
                $projectStatus['on_hold'] ?? 0,
            ];
            $projectColors = ['#8b5cf6', '#3b82f6', '#22c55e', '#f59e0b'];
        @endphp

        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-card>
                <x-slot:header>
                    <h2 class="text-base font-semibold text-gray-900">Tasks by Status</h2>
                </x-slot:header>
                @if (array_sum($taskData) > 0)
                    <x-donut-chart id="tasksChart" :labels="$taskLabels" :data="$taskData" :colors="$taskColors" />
                @else
                    <x-empty-state title="No task data" description="Tasks will appear here once created." />
                @endif
            </x-card>

            @if ($isAdmin)
                <x-card>
                    <x-slot:header>
                        <h2 class="text-base font-semibold text-gray-900">Projects by Status</h2>
                    </x-slot:header>
                    @if (array_sum($projectData) > 0)
                        <x-donut-chart id="projectsChart" :labels="$projectLabels" :data="$projectData" :colors="$projectColors" />
                    @else
                        <x-empty-state title="No project data" description="Projects will appear here once created." />
                    @endif
                </x-card>
            @else
                <x-card>
                    <x-slot:header>
                        <h2 class="text-base font-semibold text-gray-900">Quick Status Summary</h2>
                    </x-slot:header>
                    <div class="space-y-4">
                        @foreach (config('taskify.task_statuses') as $key => $label)
                            @php $count = $taskStatus[$key] ?? 0; @endphp
                            <div>
                                <div class="mb-1 flex items-center justify-between text-sm">
                                    <span class="font-medium text-gray-700">{{ $label }}</span>
                                    <span class="text-gray-500">{{ $count }}</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-gray-100">
                                    <div
                                        class="h-full rounded-full bg-brand-600 transition-all"
                                        style="width: {{ $dashboard['total_tasks'] > 0 ? ($count / $dashboard['total_tasks']) * 100 : 0 }}%"
                                    ></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            @endif
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 xl:grid-cols-3">
            {{-- Quick actions --}}
            <x-card class="xl:col-span-1">
                <x-slot:header>
                    <h2 class="text-base font-semibold text-gray-900">Quick Actions</h2>
                </x-slot:header>
                <div class="space-y-2">
                    @if ($isAdmin)
                        <x-button href="{{ route('projects.create') }}" variant="primary" class="w-full justify-start">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Create Project
                        </x-button>
                        <x-button href="{{ route('tasks.create') }}" variant="secondary" class="w-full justify-start">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                            Create Task
                        </x-button>
                        <x-button href="{{ route('projects.index') }}" variant="ghost" class="w-full justify-start">View All Projects</x-button>
                        <x-button href="{{ route('tasks.index') }}" variant="ghost" class="w-full justify-start">View All Tasks</x-button>
                    @else
                        <x-button href="{{ route('tasks.my') }}" variant="primary" class="w-full justify-start">View My Tasks</x-button>
                    @endif
                </div>
            </x-card>

            {{-- Recent activity --}}
            <x-card class="xl:col-span-2">
                <x-slot:header>
                    <h2 class="text-base font-semibold text-gray-900">Recent Activity</h2>
                </x-slot:header>
                @if (! empty($dashboard['recent_activity']))
                    <ul class="divide-y divide-gray-100">
                        @foreach ($dashboard['recent_activity'] as $activity)
                            <li class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-700">{{ $activity['message'] }}</p>
                                    @if ($activity['time'])
                                        <p class="mt-0.5 text-xs text-gray-400">{{ Carbon::parse($activity['time'])->diffForHumans() }}</p>
                                    @endif
                                </div>
                                <x-status-badge :status="$activity['status']" />
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-empty-state title="No recent activity" description="Activity will show up as tasks are updated." />
                @endif
            </x-card>
        </div>

        {{-- Tables --}}
        <div class="grid grid-cols-1 gap-6 {{ $isAdmin ? 'xl:grid-cols-2' : '' }}">
            <x-card :padding="false">
                <x-slot:header>
                    <div class="flex items-center justify-between px-6 pt-6">
                        <h2 class="text-base font-semibold text-gray-900">Recent Tasks</h2>
                        <x-button href="{{ $isAdmin ? route('tasks.index') : route('tasks.my') }}" variant="ghost" size="sm">View all</x-button>
                    </div>
                </x-slot:header>
                @if (! empty($dashboard['recent_tasks']))
                    <div class="hidden md:block">
                        <x-table>
                            <x-slot:header>
                                <tr>
                                    <x-table-header>Title</x-table-header>
                                    <x-table-header>Status</x-table-header>
                                    <x-table-header>Due</x-table-header>
                                </tr>
                            </x-slot:header>
                            @foreach ($dashboard['recent_tasks'] as $task)
                                <x-table-row>
                                    <x-table-cell>
                                        <a href="{{ route('tasks.show', $task['id']) }}" class="font-medium text-brand-600 hover:text-brand-700">{{ $task['title'] }}</a>
                                    </x-table-cell>
                                    <x-table-cell><x-status-badge :status="$task['status']" /></x-table-cell>
                                    <x-table-cell>{{ $task['due_date'] ? Carbon::parse($task['due_date'])->format('M j, Y') : '—' }}</x-table-cell>
                                </x-table-row>
                            @endforeach
                        </x-table>
                    </div>
                    <div class="space-y-3 p-4 md:hidden">
                        @foreach ($dashboard['recent_tasks'] as $task)
                            <a href="{{ route('tasks.show', $task['id']) }}" class="block rounded-lg border border-gray-200 p-4 hover:border-brand-200 hover:bg-brand-50/50 transition-colors">
                                <p class="font-medium text-gray-900">{{ $task['title'] }}</p>
                                <div class="mt-2 flex items-center gap-2">
                                    <x-status-badge :status="$task['status']" />
                                    <span class="text-xs text-gray-500">{{ $task['due_date'] ? Carbon::parse($task['due_date'])->format('M j') : 'No due date' }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-6"><x-empty-state title="No tasks yet" /></div>
                @endif
            </x-card>

            @if ($isAdmin)
                <x-card :padding="false">
                    <x-slot:header>
                        <div class="flex items-center justify-between px-6 pt-6">
                            <h2 class="text-base font-semibold text-gray-900">Recent Projects</h2>
                            <x-button href="{{ route('projects.index') }}" variant="ghost" size="sm">View all</x-button>
                        </div>
                    </x-slot:header>
                    @if (! empty($dashboard['recent_projects']))
                        <div class="hidden md:block">
                            <x-table>
                                <x-slot:header>
                                    <tr>
                                        <x-table-header>Project</x-table-header>
                                        <x-table-header>Client</x-table-header>
                                        <x-table-header>Status</x-table-header>
                                    </tr>
                                </x-slot:header>
                                @foreach ($dashboard['recent_projects'] as $project)
                                    <x-table-row>
                                        <x-table-cell>
                                            <a href="{{ route('projects.show', $project['id']) }}" class="font-medium text-brand-600 hover:text-brand-700">{{ $project['name'] }}</a>
                                        </x-table-cell>
                                        <x-table-cell>{{ $project['client_name'] }}</x-table-cell>
                                        <x-table-cell><x-status-badge :status="$project['status']" /></x-table-cell>
                                    </x-table-row>
                                @endforeach
                            </x-table>
                        </div>
                        <div class="space-y-3 p-4 md:hidden">
                            @foreach ($dashboard['recent_projects'] as $project)
                                <a href="{{ route('projects.show', $project['id']) }}" class="block rounded-lg border border-gray-200 p-4 hover:border-brand-200 transition-colors">
                                    <p class="font-medium text-gray-900">{{ $project['name'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $project['client_name'] }}</p>
                                    <div class="mt-2"><x-status-badge :status="$project['status']" /></div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6"><x-empty-state title="No projects yet" /></div>
                    @endif
                </x-card>
            @endif
        </div>
    @endif

</x-layouts.app>
