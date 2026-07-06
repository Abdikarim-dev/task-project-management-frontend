@include('tasks._form', [
    'action' => route('tasks.store'),
    'method' => 'POST',
    'task' => null,
    'title' => 'Create Task',
    'submitLabel' => 'Create Task',
])
