<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function getAllForUser(int $userId, array $filters): Collection
    {
        return Task::where('tasks.user_id', $userId)
            ->leftJoin('categories', 'tasks.category_id', '=', 'categories.id')
            ->when(isset($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->when(isset($filters['priority']), fn($q) => $q->where('priority', $filters['priority']))
            ->when(isset($filters['category_id']), fn($q) => $q->where('tasks.category_id', $filters['category_id']))
            ->when(isset($filters['category_name']), fn($q) => $q->where('categories.name', 'like', '%'.$filters['category_name'].'%'))
            ->select('tasks.*')
            ->get();
    }

    public function findById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}