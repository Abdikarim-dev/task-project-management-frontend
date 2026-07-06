<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiClient;
use App\Services\Api\ApiException;
use App\Services\UserService;
use App\Support\AuthSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly ApiClient $api
    ) {}

    public function edit(): View
    {
        try {
            $response = $this->api->get('auth/me');
            $user = $response['data'];
        } catch (ApiException) {
            $user = auth_user() ?? [];
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'theme_preference' => ['nullable', 'in:light,dark'],
        ]);

        try {
            $user = $this->userService->updateProfile($validated);
            AuthSession::updateUser($user);

            return redirect()->route('profile.edit')
                ->with('success', 'Profile updated successfully.');
        } catch (ApiException $exception) {
            return back()
                ->withInput()
                ->withErrors($exception->errors())
                ->with('error', $exception->getMessage());
        }
    }

    public function updateTheme(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'theme_preference' => ['required', 'in:light,dark'],
        ]);

        try {
            $user = $this->userService->updateProfile($validated);
            AuthSession::updateUser($user);

            return response()->json([
                'theme_preference' => $user['theme_preference'] ?? 'light',
            ]);
        } catch (ApiException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }
    }
}
