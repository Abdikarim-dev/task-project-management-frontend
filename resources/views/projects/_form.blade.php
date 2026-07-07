@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app :title="$title.' — Taskify'">
    <x-page-header :title="$title">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Projects', 'url' => route('projects.index')],
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

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-input label="Project Name" name="name" :value="old('name', $project['name'] ?? '')" required :error="$errors->first('name')" class="sm:col-span-2" />
                <x-input label="Client Name" name="client_name" :value="old('client_name', $project['client_name'] ?? '')" required :error="$errors->first('client_name')" class="sm:col-span-2" />
                <x-select label="Status" name="status" required :error="$errors->first('status')">
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $project['status'] ?? 'planning') === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
                <div></div>
                <x-input label="Start Date" name="start_date" type="date" :value="old('start_date', $project['start_date'] ?? '')" required :error="$errors->first('start_date')" />
                <x-input label="Due Date" name="due_date" type="date" :value="old('due_date', $project['due_date'] ?? '')" required :error="$errors->first('due_date')" />
            </div>

            <x-textarea label="Description" name="description" rows="4" :error="$errors->first('description')">{{ old('description', $project['description'] ?? '') }}</x-textarea>

            @if (count($staff))
                <fieldset>
                    <legend class="mb-3 text-sm font-medium text-app-secondary">Assign Team Members</legend>
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        @php $selected = old('team_member_ids', collect($project['team_members'] ?? [])->pluck('id')->all()); @endphp
                        @foreach ($staff as $member)
                            <label class="flex items-center gap-2 rounded-lg border border-app bg-surface-input px-3 py-2 transition-colors hover:bg-surface-hover">
                                <input type="checkbox" name="team_member_ids[]" value="{{ $member['id'] }}" @checked(in_array($member['id'], $selected)) class="rounded border-app bg-surface-input text-brand-600 focus:ring-brand-500 focus:ring-offset-[var(--surface)]" />
                                <span class="text-sm text-app-primary">{{ $member['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>
            @endif

            <div class="flex items-center gap-3 border-t border-app-subtle pt-6">
                <x-button type="submit" variant="primary">{{ $submitLabel }}</x-button>
                <x-button href="{{ route('projects.index') }}" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
