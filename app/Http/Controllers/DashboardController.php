<?php

namespace App\Http\Controllers;

use App\Services\Api\ApiException;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    public function index(): View
    {
        try {
            $dashboard = $this->dashboardService->getData();
        } catch (ApiException $exception) {
            return view('dashboard.index', [
                'dashboard' => null,
                'error' => $exception->getMessage(),
            ]);
        }

        return view('dashboard.index', compact('dashboard'));
    }
}
