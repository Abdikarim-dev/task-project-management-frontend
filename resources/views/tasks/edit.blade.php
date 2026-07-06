@include('tasks._form', [
    'action' => route('tasks.update', $task['id']),
    'method' => 'PUT',
    'task' => $task,
    'title' => 'Edit Task',
    'submitLabel' => 'Save Changes',
])
