<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
     // POST /tasks
     public function store(Request $request)
     {
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'project_id' => 'required|exists:projects,id',
             'assigned_user_id' => 'required|exists:users,id',
             'due_date' => 'required|date',
         ]);
 
         $task = Task::create([
             'title' => $validated['title'],
             'description' => $validated['description'],
             'project_id' => $validated['project_id'],
             'assigned_user_id' => $validated['assigned_user_id'],
             'status' => 'Pending',
             'due_date' => $validated['due_date'],
         ]);
 
         return response()->json($task, 201);
     }
 
     // GET /tasks
     public function index(Request $request)
     {
         $tasks = Task::query()
             ->when($request->project_id, fn($query) => $query->where('project_id', $request->project_id))
             ->when($request->assigned_user_id, fn($query) => $query->where('assigned_user_id', $request->assigned_user_id))
             ->when($request->status, fn($query) => $query->where('status', $request->status))
             ->paginate(10);
 
         return response()->json($tasks);
     }
 
     // PUT /tasks/{id}
     public function update(Request $request, $id)
     {
         $task = Task::findOrFail($id);
 
         $validated = $request->validate([
             'title' => 'sometimes|string|max:255',
             'description' => 'sometimes|string',
             'status' => 'sometimes|in:Pending,In Progress,Completed',
             'due_date' => 'sometimes|date',
         ]);
 
         $task->update($validated);
 
         return response()->json($task);
     }
 
     // DELETE /tasks/{id}
     public function destroy($id)
     {
         $task = Task::findOrFail($id);
         $task->delete();
 
         return response()->json(['message' => 'Task deleted successfully']);
     }
}
