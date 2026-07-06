<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiPaginator
{
    /**
     * @param  list<array<string, mixed>>  $items
     * @param  array<string, mixed>  $pagination
     */
    public static function make(array $items, array $pagination, Request $request): LengthAwarePaginator
    {
        return new LengthAwarePaginator(
            $items,
            (int) ($pagination['total'] ?? count($items)),
            (int) ($pagination['per_page'] ?? 15),
            (int) ($pagination['current_page'] ?? 1),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
