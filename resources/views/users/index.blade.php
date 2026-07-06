@php use Illuminate\Support\Carbon; @endphp

<x-layouts.app title="Users — Taskify">
    <x-page-header title="User Management" description="View and manage team members">
        <x-slot:actions>
            <form method="GET" class="flex gap-2">
                <x-search-box name="search" :value="request('search')" placeholder="Search users..." />
            </form>
        </x-slot:actions>
    </x-page-header>

    @isset($error)
        <x-alert type="error" class="mb-6">{{ $error }}</x-alert>
    @endif

    <form method="GET" class="mb-6 flex flex-wrap gap-3">
        @if (request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <x-select name="role" placeholder="All roles" class="w-48">
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="staff" @selected(request('role') === 'staff')>Staff</option>
        </x-select>
        <x-button type="submit" variant="secondary">Filter</x-button>
    </form>

    @if ($users->count())
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($users as $user)
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <x-avatar :name="$user['name']" size="lg" />
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $user['name'] }}</h3>
                                <p class="text-sm text-gray-500">{{ $user['role_label'] }}</p>
                            </div>
                        </div>
                        <x-badge :variant="$user['role'] === 'admin' ? 'primary' : 'default'">{{ $user['role_label'] }}</x-badge>
                    </div>

                    <dl class="mt-4 space-y-2 text-sm">
                        <div>
                            <dt class="text-gray-500">Email</dt>
                            <dd class="font-medium text-gray-900">{{ $user['email'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Member since</dt>
                            <dd class="text-gray-700">{{ Carbon::parse($user['created_at'])->format('M j, Y') }}</dd>
                        </div>
                    </dl>

                    <div class="mt-4 flex gap-2 border-t border-gray-100 pt-4">
                        <x-button :href="route('users.show', $user['id'])" variant="secondary" size="sm" class="flex-1">View Profile</x-button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6"><x-pagination :paginator="$users" /></div>
    @else
        <x-empty-state title="No users found" description="Try adjusting your search or filters." />
    @endif
</x-layouts.app>
