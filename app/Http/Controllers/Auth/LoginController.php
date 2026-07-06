<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\ApiClient;
use App\Services\Api\ApiException;
use App\Support\AuthSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly ApiClient $api
    ) {}

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $response = $this->api->post('auth/login', $credentials);
            $data = $response['data'];

            AuthSession::login($data['token'], $data['user']);

            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Welcome back, '.$data['user']['name'].'!');
        } catch (ApiException $exception) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => $exception->getMessage()]);
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        try {
            $this->api->post('auth/logout');
        } catch (ApiException) {
            // Continue logout even if API call fails
        }

        AuthSession::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been signed out.');
    }
}
