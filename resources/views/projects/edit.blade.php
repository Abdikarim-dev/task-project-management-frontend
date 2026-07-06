@include('projects._form', [
    'action' => route('projects.update', $project['id']),
    'method' => 'PUT',
    'project' => $project,
    'title' => 'Edit Project',
    'submitLabel' => 'Save Changes',
])
