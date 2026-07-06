<?php

namespace App\Services;

use App\Services\Api\ApiClient;
use App\Services\Api\ApiException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Support\ApiPaginator;

class ProjectService
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
            'status' => $request->string('status')->toString() ?: null,
        ]);

        $response = $this->api->get('projects', $query);
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
        $response = $this->api->get("projects/{$id}");

        return $response['data'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        $response = $this->api->post('projects', $data);

        return $response['data'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function update(int $id, array $data): array
    {
        $response = $this->api->put("projects/{$id}", $data);

        return $response['data'];
    }

    public function delete(int $id): void
    {
        $this->api->delete("projects/{$id}");
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function staffOptions(): array
    {
        try {
            $response = $this->api->get('projects', ['per_page' => 100]);
            $projects = $response['data']['items'] ?? [];

            return collect($projects)
                ->flatMap(fn (array $project) => $project['team_members'] ?? [])
                ->unique('id')
                ->sortBy('name')
                ->values()
                ->all();
        } catch (ApiException) {
            return [];
        }
    }
}
