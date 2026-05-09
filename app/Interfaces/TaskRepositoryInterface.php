<?php

namespace App\Interfaces;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function getAllForUser(int $userId, array $filters): Collection;
    public function findById(int $id): Task;
    public function create(array $data): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): void;
}