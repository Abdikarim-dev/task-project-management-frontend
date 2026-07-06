<?php

namespace App\Services\Api;

use Exception;
use Illuminate\Http\Client\Response;

class ApiException extends Exception
{
    /**
     * @param  array<string, mixed>  $errors
     */
    public function __construct(
        string $message,
        private readonly int $statusCode = 500,
        private readonly array $errors = []
    ) {
        parent::__construct($message, $statusCode);
    }

    public static function fromResponse(Response $response): self
    {
        $body = $response->json() ?? [];

        return new self(
            $body['message'] ?? $response->reason(),
            $response->status(),
            $body['errors'] ?? []
        );
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array<string, mixed>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
