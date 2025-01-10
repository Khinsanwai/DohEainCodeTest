<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ProjectController extends Controller
{

    // POST /projects
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'manager_id' => $validated['manager_id'],
            'status' => 'Active',
        ]);

        return response()->json($project, 201);
    }

    // GET /projects
    public function index(Request $request)
    {
        $projects = Project::query()
            ->when($request->status, fn($query) => $query->where('status', $request->status))
            ->when($request->manager_id, fn($query) => $query->where('manager_id', $request->manager_id))
            ->paginate(10);

        return response()->json($projects);
    }

    // GET /projects/{id}
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    // PUT /projects/{id}
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'manager_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|in:Active,Inactive',
        ]);

        $project->update($validated);

        return response()->json($project);
    }

    // DELETE /projects/{id}
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully']);
    }
    public function summary($id) {
        $project = Project::with('tasks')->findOrFail($id);
        return [
            'total_tasks' => $project->tasks->count(),
            'statuses' => $project->tasks->groupBy('status')->map(fn($tasks) => $tasks->count()),
        ];
    }
    
}
