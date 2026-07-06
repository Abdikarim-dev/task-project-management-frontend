<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiException;
use App\Services\ProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(
        private readonly ProjectService $projectService
    ) {}

    public function index(Request $request): View
    {
        try {
            $projects = $this->projectService->paginate($request);
        } catch (ApiException $exception) {
            return view('projects.index', [
                'projects' => collect(),
                'error' => $exception->getMessage(),
            ]);
        }

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('projects.create', [
            'staff' => $this->projectService->staffOptions(),
            'statuses' => config('taskify.project_statuses'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:'.implode(',', array_keys(config('taskify.project_statuses')))],
            'team_member_ids' => ['nullable', 'array'],
            'team_member_ids.*' => ['integer'],
        ]);

        try {
            $this->projectService->create($validated);

            return redirect()->route('projects.index')
                ->with('success', 'Project created successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function show(int $project): View|RedirectResponse
    {
        try {
            $projectData = $this->projectService->find($project);
        } catch (ApiException $exception) {
            return redirect()->route('projects.index')
                ->with('error', $exception->getMessage());
        }

        return view('projects.show', ['project' => $projectData]);
    }

    public function edit(int $project): View|RedirectResponse
    {
        try {
            $projectData = $this->projectService->find($project);
        } catch (ApiException $exception) {
            return redirect()->route('projects.index')
                ->with('error', $exception->getMessage());
        }

        return view('projects.edit', [
            'project' => $projectData,
            'staff' => $this->projectService->staffOptions(),
            'statuses' => config('taskify.project_statuses'),
        ]);
    }

    public function update(Request $request, int $project): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'client_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:'.implode(',', array_keys(config('taskify.project_statuses')))],
            'team_member_ids' => ['nullable', 'array'],
            'team_member_ids.*' => ['integer'],
        ]);

        try {
            $this->projectService->update($project, $validated);

            return redirect()->route('projects.show', $project)
                ->with('success', 'Project updated successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(int $project): RedirectResponse
    {
        try {
            $this->projectService->delete($project);

            return redirect()->route('projects.index')
                ->with('success', 'Project deleted successfully.');
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
