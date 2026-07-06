@php
    $selectedProjectId = (string) old('project_id', $task['project']['id'] ?? ($projects[0]['id'] ?? ''));
    $selectedAssigneeId = (string) old('assigned_to', $task['assignee']['id'] ?? '');
    $currentAssignee = $task['assignee'] ?? null;

    $projectTeams = collect($projects)->mapWithKeys(function (array $project): array {
        $members = collect($project['team_members'] ?? [])
            ->map(fn (array $member): array => [
                'id' => $member['id'],
                'name' => $member['name'],
            ])
            ->values()
            ->all();

        return [(string) $project['id'] => $members];
    })->all();
@endphp

<x-layouts.app :title="$title.' — Taskify'">
    <x-page-header :title="$title">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Tasks', 'url' => route('tasks.index')],
                ['label' => $title],
            ]" />
        </x-slot:breadcrumb>
    </x-page-header>

    <x-card class="max-w-3xl">
        <form
            method="POST"
            action="{{ $action }}"
            class="space-y-6"
            x-data="{
                projectTeams: @js($projectTeams),
                currentAssignee: @js($currentAssignee),
                selectedProject: @js($selectedProjectId),
                selectedAssignee: @js($selectedAssigneeId),
                get assignees() {
                    const team = this.projectTeams[this.selectedProject] ?? [];
                    if (this.currentAssignee && ! team.some(member => String(member.id) === String(this.currentAssignee.id))) {
                        return [this.currentAssignee, ...team];
                    }
                    return team;
                },
                onProjectChange() {
                    const team = this.projectTeams[this.selectedProject] ?? [];
                    if (this.selectedAssignee && ! team.some(member => String(member.id) === String(this.selectedAssignee))) {
                        this.selectedAssignee = '';
                    }
                }
            }"
        >
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <x-input label="Title" name="title" :value="old('title', $task['title'] ?? '')" required :error="$errors->first('title')" />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="project_id" class="block text-sm font-medium text-app-secondary">
                        Project <span class="text-red-500" aria-hidden="true">*</span>
                    </label>
                    <div class="relative">
                        <select
                            name="project_id"
                            id="project_id"
                            required
                            x-model="selectedProject"
                            x-on:change="onProjectChange()"
                            class="block w-full appearance-none rounded-lg border border-app bg-surface-input px-3.5 py-2.5 pr-10 text-sm text-app-primary shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        >
                            @foreach ($projects as $project)
                                <option value="{{ $project['id'] }}">{{ $project['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-4 w-4 text-app-muted" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        </div>
                    </div>
                    @if ($errors->first('project_id'))
                        <p class="text-sm text-red-500" role="alert">{{ $errors->first('project_id') }}</p>
                    @endif
                </div>

                <div class="space-y-1.5">
                    <label for="assigned_to" class="block text-sm font-medium text-app-secondary">Assigned User</label>
                    <div class="relative">
                        <select
                            name="assigned_to"
                            id="assigned_to"
                            x-model="selectedAssignee"
                            class="block w-full appearance-none rounded-lg border border-app bg-surface-input px-3.5 py-2.5 pr-10 text-sm text-app-primary shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500"
                        >
                            <option value="">Unassigned</option>
                            <template x-for="member in assignees" :key="member.id">
                                <option :value="member.id" x-text="member.name"></option>
                            </template>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-4 w-4 text-app-muted" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        </div>
                    </div>
                    <p class="text-xs text-app-muted">Only staff assigned to the selected project can be chosen.</p>
                    @if ($errors->first('assigned_to'))
                        <p class="text-sm text-red-500" role="alert">{{ $errors->first('assigned_to') }}</p>
                    @endif
                </div>

                <x-select label="Priority" name="priority" required :error="$errors->first('priority')">
                    @foreach ($priorities as $value => $label)
                        <option value="{{ $value }}" @selected(old('priority', $task['priority'] ?? 'medium') === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>

                <x-select label="Status" name="status" required :error="$errors->first('status')">
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $task['status'] ?? 'to_do') === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>

                <x-input label="Due Date" name="due_date" type="date" :value="old('due_date', $task['due_date'] ?? '')" :error="$errors->first('due_date')" class="sm:col-span-2" />
            </div>

            <x-textarea label="Description" name="description" rows="4" :error="$errors->first('description')">{{ old('description', $task['description'] ?? '') }}</x-textarea>

            <div class="flex items-center gap-3 border-t border-app-subtle pt-6">
                <x-button type="submit" variant="primary">{{ $submitLabel }}</x-button>
                <x-button href="{{ route('tasks.index') }}" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
