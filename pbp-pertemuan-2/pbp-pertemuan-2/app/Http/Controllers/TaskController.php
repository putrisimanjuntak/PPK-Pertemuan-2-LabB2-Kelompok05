<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name', 'asc')->get();
        return view('tasks.index', compact('projects'));
    }

    public function getTasks()
    {
        $tasks = Task::with('project')->latest()->get();
        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id() ?? User::first()->id ?? 1;
        $data['status']  = 'todo';

        $task = Task::create($data);

        return response()->json($task->load('project'), 201);
    }

    public function toggle(Task $task)
    {
        $isDone = ($task->status === 'done');
        $task->status = $isDone ? 'todo' : 'done';
        $task->completed_at = $isDone ? null : now();
        $task->save();

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task berhasil dihapus']);
    }
}