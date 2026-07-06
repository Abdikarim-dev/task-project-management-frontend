<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backend API Configuration
    |--------------------------------------------------------------------------
    */

    'base_url' => env('API_BASE_URL', 'http://localhost:8000/api'),

    'timeout' => (int) env('API_TIMEOUT', 30),

];
