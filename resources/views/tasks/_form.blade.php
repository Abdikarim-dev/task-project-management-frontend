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
        <form method="POST" action="{{ $action }}" class="space-y-6">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            <x-input label="Title" name="title" :value="old('title', $task['title'] ?? '')" required :error="$errors->first('title')" />

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-select label="Project" name="project_id" required :error="$errors->first('project_id')">
                    @foreach ($projects as $project)
                        <option value="{{ $project['id'] }}" @selected(old('project_id', $task['project']['id'] ?? '') == $project['id'])>{{ $project['name'] }}</option>
                    @endforeach
                </x-select>

                <x-select label="Assigned User" name="assigned_to" placeholder="Unassigned" :error="$errors->first('assigned_to')">
                    @foreach ($assignees as $assignee)
                        <option value="{{ $assignee['id'] }}" @selected(old('assigned_to', $task['assignee']['id'] ?? '') == $assignee['id'])>{{ $assignee['name'] }}</option>
                    @endforeach
                </x-select>

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

            <div class="flex items-center gap-3 border-t border-gray-100 pt-6">
                <x-button type="submit" variant="primary">{{ $submitLabel }}</x-button>
                <x-button href="{{ route('tasks.index') }}" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
