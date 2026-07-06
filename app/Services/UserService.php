<?php

namespace App\Services;

use App\Services\Api\ApiClient;
use App\Services\Api\ApiException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Support\ApiPaginator;

class UserService
{
    public function __construct(
        private readonly ApiClient $api
    ) {}

    public function paginate(Request $request): LengthAwarePaginator
    {
        $query = array_filter([
            'per_page' => $request->integer('per_page', 15),
            'page' => $request->integer('page', 1),
            'search' => $request->string('search')->toString() ?: null,
            'role' => $request->string('role')->toString() ?: null,
        ]);

        $response = $this->api->get('users', $query);
        $payload = $response['data'];

        return ApiPaginator::make(
            $payload['items'] ?? [],
            $payload['pagination'] ?? [],
            $request
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function find(int $id): array
    {
        $response = $this->api->get("users/{$id}");

        return $response['data'];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function staffOptions(): array
    {
        try {
            $response = $this->api->get('users', ['role' => 'staff', 'per_page' => 100]);

            return $response['data']['items'] ?? [];
        } catch (ApiException) {
            return [];
        }
    }
}
