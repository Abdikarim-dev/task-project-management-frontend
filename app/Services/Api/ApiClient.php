<?php

namespace App\Services\Api;

use App\Support\AuthSession;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiClient
{
    protected function client(): PendingRequest
    {
        $client = Http::baseUrl(rtrim(config('api.base_url'), '/'))
            ->acceptJson()
            ->timeout(config('api.timeout', 30));

        if ($token = AuthSession::token()) {
            $client->withToken($token);
        }

        return $client;
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<string, mixed>
     */
    public function get(string $endpoint, array $query = []): array
    {
        return $this->handleResponse(
            $this->client()->get($this->normalizeEndpoint($endpoint), $query)
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function post(string $endpoint, array $data = []): array
    {
        return $this->handleResponse(
            $this->client()->post($this->normalizeEndpoint($endpoint), $data)
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function put(string $endpoint, array $data = []): array
    {
        return $this->handleResponse(
            $this->client()->put($this->normalizeEndpoint($endpoint), $data)
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function patch(string $endpoint, array $data = []): array
    {
        return $this->handleResponse(
            $this->client()->patch($this->normalizeEndpoint($endpoint), $data)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function delete(string $endpoint): array
    {
        return $this->handleResponse(
            $this->client()->delete($this->normalizeEndpoint($endpoint))
        );
    }

    protected function normalizeEndpoint(string $endpoint): string
    {
        return '/'.ltrim($endpoint, '/');
    }

    /**
     * @return array<string, mixed>
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->failed()) {
            throw ApiException::fromResponse($response);
        }

        $body = $response->json();

        if (! is_array($body) || ! ($body['success'] ?? false)) {
            throw new ApiException(
                is_array($body) ? ($body['message'] ?? 'API request failed.') : 'API request failed.',
                $response->status(),
                is_array($body) ? ($body['errors'] ?? []) : []
            );
        }

        return $body;
    }
}
