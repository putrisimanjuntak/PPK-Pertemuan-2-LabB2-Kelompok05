<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('name', 'asc')->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
        ]);

        $userId = auth()->id() ?? User::first()->id ?? 1;

        $project = Project::create([
            'user_id' => $userId,
            'name'    => trim($validated['name']),
        ]);

        return response()->json($project, 201);
    }
}