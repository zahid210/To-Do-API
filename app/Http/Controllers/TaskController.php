<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index(Request $request): AnonymousResourceCollection
    {
        // Columnas permitidas para ordenar
        $allowedSorts = ['created_at', 'due_date', 'priority', 'title', 'status'];
        $sortBy  = in_array($request->sort_by, $allowedSorts) ? $request->sort_by : 'created_at';
        $sortDir = in_array($request->sort_dir, ['asc', 'desc']) ? $request->sort_dir : 'desc';
        $perPage = min((int) ($request->per_page ?? 10), 50); // máximo 50 por página

        $tasks = $request->user()
            ->tasks()
            ->with('category')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->priority, fn($q) => $q->where('priority', $request->priority))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->orderBy($sortBy, $sortDir)
            ->paginate($perPage);

        return TaskResource::collection($tasks);
    }

    // POST /api/tasks
    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = $request->user()
            ->tasks()
            ->create($request->validated());

        return new TaskResource($task->load('category'));
    }

    // GET /api/tasks/{task}
    public function show(Request $request, Task $task): TaskResource|JsonResponse
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        return new TaskResource($task->load('category'));
    }

    // PUT /api/tasks/{task}
    public function update(UpdateTaskRequest $request, Task $task): TaskResource|JsonResponse
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $task->update($request->validated());

        return new TaskResource($task->load('category'));
    }

    // DELETE /api/tasks/{task}
    public function destroy(Request $request, Task $task): JsonResponse
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado.'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Tarea eliminada correctamente.']);
    }
}
