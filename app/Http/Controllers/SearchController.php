<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Search Projects and Tasks by name or description
        $projects = Project::where('name', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->get();

        $tasks = Task::where('name', 'like', "%$query%")
                      ->orWhere('description', 'like', "%$query%")
                      ->get();

        return response()->json([
            'projects' => $projects,
            'tasks' => $tasks,
        ]);
    }
}
