<?php

namespace App\Services;

use App\Services\Api\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Support\ApiPaginator;

class TaskService
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
            'priority' => $request->string('priority')->toString() ?: null,
            'project_id' => $request->integer('project_id') ?: null,
            'sort' => $request->string('sort')->toString() ?: null,
        ]);

        $response = $this->api->get('tasks', $query);
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
        $response = $this->api->get("tasks/{$id}");

        return $response['data'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function create(array $data): array
    {
        $response = $this->api->post('tasks', $data);

        return $response['data'];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function update(int $id, array $data): array
    {
        $response = $this->api->put("tasks/{$id}", $data);

        return $response['data'];
    }

    /**
     * @return array<string, mixed>
     */
    public function updateStatus(int $id, string $status): array
    {
        $response = $this->api->patch("tasks/{$id}/status", ['status' => $status]);

        return $response['data'];
    }

    public function delete(int $id): void
    {
        $this->api->delete("tasks/{$id}");
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function projectOptions(): array
    {
        $response = $this->api->get('projects', ['per_page' => 100]);

        return $response['data']['items'] ?? [];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function assigneeOptions(): array
    {
        return app(UserService::class)->staffOptions();
    }
}
