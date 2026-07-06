@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app title="Users — Taskify">
    <x-page-header title="User Management" description="View and manage team members">
        <x-slot:actions>
            <x-button href="{{ route('users.create') }}">Create User</x-button>
        </x-slot:actions>
    </x-page-header>

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
    @endif

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        <x-search-box name="search" :value="request('search')" placeholder="Search users..." class="flex-1 min-w-[200px]" />
        <x-select name="role" placeholder="All roles" class="w-48">
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="staff" @selected(request('role') === 'staff')>Staff</option>
        </x-select>
        <x-button type="submit" variant="secondary">Filter</x-button>
    </form>

    @if ($users->count())
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($users as $user)
                <div class="rounded-xl border border-app bg-surface p-6 shadow-sm transition-shadow hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$user['name']" size="lg" />
                            <div>
                                <h3 class="font-semibold text-app-primary">{{ $user['name'] }}</h3>
                                <p class="text-sm text-app-secondary">{{ $user['role_label'] }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <x-badge :variant="$user['role'] === 'admin' ? 'primary' : 'default'">{{ $user['role_label'] }}</x-badge>
                            @if ($user['is_suspended'] ?? false)
                                <x-badge variant="danger">Suspended</x-badge>
                            @endif
                        </div>
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div>
                            <dt class="text-app-muted">Email</dt>
                            <dd class="font-medium text-app-primary">{{ $user['email'] }}</dd>
                        </div>
                        @if (! empty($user['job_title']))
                            <div>
                                <dt class="text-app-muted">Job Title</dt>
                                <dd class="text-app-secondary">{{ $user['job_title'] }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-app-muted">Member since</dt>
                            <dd class="text-app-secondary">{{ Carbon::parse($user['created_at'])->format('M j, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 flex gap-2 border-t border-gray-100 pt-4 dark:border-gray-800">
                        <x-button :href="route('users.show', $user['id'])" variant="secondary" size="sm" class="flex-1">View Profile</x-button>
                        @if (($user['id'] ?? null) !== (auth_user()['id'] ?? null) || $user['role'] !== 'admin')
                            <form method="POST" action="{{ route('users.suspend', $user['id']) }}">
                                @csrf
                                @method('PATCH')
                                <x-button type="submit" :variant="($user['is_suspended'] ?? false) ? 'primary' : 'danger'" size="sm">
                                    {{ ($user['is_suspended'] ?? false) ? 'Activate' : 'Suspend' }}
                                </x-button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6"><x-pagination :paginator="$users" /></div>
    @else
        <x-empty-state title="No users found" description="Try adjusting your search or filters.">
            <x-button href="{{ route('users.create') }}" class="mt-4">Create User</x-button>
        </x-empty-state>
    @endif
</x-layouts.app>
