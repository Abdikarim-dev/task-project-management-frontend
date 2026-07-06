<?php

namespace App\Services;

use App\Services\Api\ApiClient;
use App\Support\AuthSession;

class DashboardService
{
    public function __construct(
        private readonly ApiClient $api
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        $response = $this->api->get('dashboard');
        $data = $response['data'];

        if (AuthSession::isAdmin()) {
            $projectsResponse = $this->api->get('projects', ['per_page' => 100]);
            $projects = $projectsResponse['data']['items'] ?? [];

            $data['recent_projects'] = array_slice($projects, 0, 5);
            $data['projects_by_status'] = $this->aggregateProjectsByStatus($projects);
        }

        $data['recent_activity'] = $this->buildActivityFeed($data['recent_tasks'] ?? []);

        return $data;
    }

    /**
     * @param  list<array<string, mixed>>  $projects
     * @return array<string, int>
     */
    private function aggregateProjectsByStatus(array $projects): array
    {
        $counts = array_fill_keys(array_keys(config('taskify.project_statuses')), 0);

        foreach ($projects as $project) {
            $status = $project['status'] ?? null;
            if ($status && isset($counts[$status])) {
                $counts[$status]++;
            }
        }

        return $counts;
    }

    /**
     * @param  list<array<string, mixed>>  $tasks
     * @return list<array<string, mixed>>
     */
    private function buildActivityFeed(array $tasks): array
    {
        return collect($tasks)
            ->sortByDesc('updated_at')
            ->take(8)
            ->map(function (array $task): array {
                $assignee = $task['assignee']['name'] ?? 'Someone';
                $action = match ($task['status'] ?? '') {
                    'completed' => 'completed',
                    'in_progress' => 'started working on',
                    default => 'was assigned',
                };

                return [
                    'id' => $task['id'],
                    'message' => "{$assignee} {$action} \"{$task['title']}\"",
                    'time' => $task['updated_at'] ?? $task['created_at'],
                    'status' => $task['status'],
                ];
            })
            ->values()
            ->all();
    }
}
