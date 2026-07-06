<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiException;
use App\Services\UserService;
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

    public function show(int $user): View
    {
        try {
            $userData = $this->userService->find($user);
        } catch (ApiException $exception) {
            return view('users.index', [
                'users' => collect(),
                'error' => $exception->getMessage(),
            ]);
        }

        return view('users.show', ['user' => $userData]);
    }
}
