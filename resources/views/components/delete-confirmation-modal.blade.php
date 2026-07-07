@props([
    'name' => 'delete-confirmation',
    'title' => 'Delete item?',
    'message' => 'This action cannot be undone. All associated data will be permanently removed.',
    'confirmLabel' => 'Delete',
    'cancelLabel' => 'Cancel',
    'action' => '#',
    'method' => 'DELETE',
])

<x-modal :name="$name" :title="$title" maxWidth="sm">
    <p class="text-sm text-app-secondary">{{ $message }}</p>

    <div class="mt-6 flex items-center justify-end gap-3">
        <x-button type="button" variant="secondary" x-on:click="$dispatch('close-modal', '{{ $name }}')">
            {{ $cancelLabel }}
        </x-button>

        <form method="POST" action="{{ $action }}">
            @csrf
            @method($method)
            <x-button type="submit" variant="danger">
                {{ $confirmLabel }}
            </x-button>
        </form>
    </div>
</x-modal>
