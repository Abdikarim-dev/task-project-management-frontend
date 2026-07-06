<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiException;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(Request $request): View
    {
        try {
            $users = $this->userService->paginate($request);
        } catch (ApiException $exception) {
            return view('users.index', [
                'users' => collect(),
                'error' => $exception->getMessage(),
            ]);
        }

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create', [
            'roles' => ['admin' => 'Admin', 'staff' => 'Staff'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,staff'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'bio' => ['nullable', 'string'],
        ]);

        try {
            $this->userService->create($validated);

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function show(int $user): View|RedirectResponse
    {
        try {
            $userData = $this->userService->find($user);
        } catch (ApiException $exception) {
            return redirect()->route('users.index')
                ->with('error', $exception->getMessage());
        }

        return view('users.show', ['user' => $userData]);
    }

    public function suspend(int $user): RedirectResponse
    {
        try {
            $updated = $this->userService->suspend($user);
            $message = ($updated['is_suspended'] ?? false)
                ? 'User suspended successfully.'
                : 'User reactivated successfully.';

            return back()->with('success', $message);
        } catch (ApiException $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
