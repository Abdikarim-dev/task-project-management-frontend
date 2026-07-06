@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app :title="$user['name'].' — Taskify'">
    <x-page-header :title="$user['name']" :description="$user['email']">
        <x-slot:breadcrumb>
            <x-breadcrumb :items="[
                ['label' => 'Users', 'url' => route('users.index')],
                ['label' => $user['name']],
            ]" />
        </x-slot:breadcrumb>
    </x-page-header>

    <x-card class="max-w-2xl">
        <div class="flex items-center gap-4">
            <x-avatar :name="$user['name']" size="xl" />
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $user['name'] }}</h2>
                <p class="text-gray-500">{{ $user['email'] }}</p>
                <div class="mt-2">
                    <x-badge :variant="$user['role'] === 'admin' ? 'primary' : 'default'">{{ $user['role_label'] }}</x-badge>
                </div>
            </div>
        </div>

        <dl class="mt-6 grid grid-cols-1 gap-4 border-t border-gray-100 pt-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm text-gray-500">Role</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user['role_label'] }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Joined</dt>
                <dd class="mt-1 text-sm font-medium text-gray-900">{{ Carbon::parse($user['created_at'])->format('F j, Y') }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <x-button href="{{ route('users.index') }}" variant="secondary">Back to Users</x-button>
        </div>
    </x-card>
</x-layouts.app>
