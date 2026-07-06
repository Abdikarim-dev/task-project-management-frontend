@include('projects._form', [
    'action' => route('projects.store'),
    'method' => 'POST',
    'project' => null,
    'title' => 'Create Project',
    'submitLabel' => 'Create Project',
])
