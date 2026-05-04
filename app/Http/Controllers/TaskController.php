<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $tasks = Task::where('user_id', auth()->id())
            // فلترة بالـ status لو اتبعت في الـ query string
            // مثال: /api/tasks?status=pending
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            // فلترة بالـ priority
            // مثال: /api/tasks?priority=high
            ->when(request('priority'), fn($q) => $q->where('priority', request('priority')))
            // فلترة بالـ category
            // مثال: /api/tasks?category_id=1
            ->when(request('category_id'), fn($q) => $q->where('category_id', request('category_id')))

            
            ->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create([
            'user_id'     => auth()->id(), // ربط الـ task بالـ user الحالي
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'priority'    => $request->priority ?? 'medium',   // default medium
            'status'      => $request->status ?? 'pending',    // default pending
            'due_date'    => $request->due_date,
        ]);

        return response()->json($task, 201); // 201 = Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
            // التأكد إن الـ task دي بتاعة الـ user الحالي
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
          // التأكد إن الـ task دي بتاعة الـ user الحالي
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->update($request->validated());

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
         // التأكد إن الـ task دي بتاعة الـ user الحالي
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
    
}
