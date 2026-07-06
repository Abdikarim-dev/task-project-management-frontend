<x-layouts.app title="Create User — Taskify">
    <x-page-header title="Create User" description="Add a new team member">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Users', 'url' => route('users.index')],
                ['label' => 'Create User'],
            ]" />
        </x-slot:breadcrumb>
    </x-page-header>

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <x-input label="Full Name" name="name" :value="old('name')" required :error="$errors->first('name')" class="sm:col-span-2" />
                <x-input label="Email" name="email" type="email" :value="old('email')" required :error="$errors->first('email')" class="sm:col-span-2" />
                <x-input label="Password" name="password" type="password" required :error="$errors->first('password')" />
                <x-input label="Confirm Password" name="password_confirmation" type="password" required />
                <x-select label="Role" name="role" required :error="$errors->first('role')">
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" @selected(old('role', 'staff') === $value)>{{ $label }}</option>
                    @endforeach
                </x-select>
                <x-input label="Job Title" name="job_title" :value="old('job_title')" :error="$errors->first('job_title')" />
                <x-input label="Phone" name="phone" type="tel" :value="old('phone')" :error="$errors->first('phone')" class="sm:col-span-2" />
            </div>

            <x-textarea label="Bio" name="bio" rows="4" :error="$errors->first('bio')">{{ old('bio') }}</x-textarea>

            <div class="flex gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                <x-button type="submit">Create User</x-button>
                <x-button href="{{ route('users.index') }}" variant="secondary">Cancel</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.app>
