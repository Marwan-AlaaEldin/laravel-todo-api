<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Interfaces\TaskRepositoryInterface;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function index()
    {
        $tasks = $this->taskRepository->getAllForUser(
            auth()->id(),
            request()->only(['status', 'priority', 'category_id', 'category_name'])
        );

        // return collection from TaskResource to insure response is what we intended to be
        return TaskResource::collection($tasks);
    }

    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new TaskResource($task);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskRepository->create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'priority'    => $request->priority ?? 'medium',
            'status'      => $request->status ?? 'pending',
            'due_date'    => $request->due_date,
        ]);

        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task = $this->taskRepository->update($task, $request->validated());

        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->taskRepository->delete($task);

        return response()->json(['message' => 'Task deleted']);
    }
}