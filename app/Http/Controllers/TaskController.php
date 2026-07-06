<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiException;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    public function index(Request $request): View
    {
        try {
            $tasks = $this->taskService->paginate($request);
        } catch (ApiException $exception) {
            return view('tasks.index', [
                'tasks' => collect(),
                'error' => $exception->getMessage(),
            ]);
        }

        return view('tasks.index', [
            'tasks' => $tasks,
            'projects' => $this->taskService->projectOptions(),
        ]);
    }

    public function myTasks(Request $request): View
    {
        try {
            $tasks = $this->taskService->paginate($request);
        } catch (ApiException $exception) {
            return view('staff.my-tasks', [
                'tasks' => collect(),
                'error' => $exception->getMessage(),
            ]);
        }

        return view('staff.my-tasks', compact('tasks'));
    }

    public function create(): View
    {
        return view('tasks.create', [
            'projects' => $this->taskService->projectOptions(),
            'statuses' => config('taskify.task_statuses'),
            'priorities' => config('taskify.task_priorities'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'integer'],
            'assigned_to' => ['nullable', 'integer'],
            'priority' => ['required', 'in:'.implode(',', array_keys(config('taskify.task_priorities')))],
            'status' => ['required', 'in:'.implode(',', array_keys(config('taskify.task_statuses')))],
            'due_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        try {
            $this->taskService->create($validated);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function show(int $task): View|RedirectResponse
    {
        try {
            $taskData = $this->taskService->find($task);
        } catch (ApiException $exception) {
            return redirect()->route(auth_is_admin() ? 'tasks.index' : 'tasks.my')
                ->with('error', $exception->getMessage());
        }

        return view('tasks.show', ['task' => $taskData]);
    }

    public function edit(int $task): View|RedirectResponse
    {
        try {
            $taskData = $this->taskService->find($task);
        } catch (ApiException $exception) {
            return redirect()->route('tasks.index')
                ->with('error', $exception->getMessage());
        }

        return view('tasks.edit', [
            'task' => $taskData,
            'projects' => $this->taskService->projectOptions(),
            'statuses' => config('taskify.task_statuses'),
            'priorities' => config('taskify.task_priorities'),
        ]);
    }

    public function update(Request $request, int $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'project_id' => ['required', 'integer'],
            'assigned_to' => ['nullable', 'integer'],
            'priority' => ['required', 'in:'.implode(',', array_keys(config('taskify.task_priorities')))],
            'status' => ['required', 'in:'.implode(',', array_keys(config('taskify.task_statuses')))],
            'due_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ]);

        try {
            $this->taskService->update($task, $validated);

            return redirect()->route('tasks.show', $task)
                ->with('success', 'Task updated successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function updateStatus(Request $request, int $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(config('taskify.task_statuses')))],
        ]);

        try {
            $this->taskService->updateStatus($task, $validated['status']);

            return back()->with('success', 'Task status updated successfully.');
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy(int $task): RedirectResponse
    {
        try {
            $this->taskService->delete($task);

            return redirect()->route('tasks.index')
                ->with('success', 'Task deleted successfully.');
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
