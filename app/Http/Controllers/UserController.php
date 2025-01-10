<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function performance(Request $request)
{
    // Validate input dates
    $validated = $request->validate([
        'start_date' => 'required|date',  // Ensure start_date is a valid date
        'end_date' => 'required|date',    // Ensure end_date is a valid date
    ]);

    // Fetch users and their completed tasks count within the date range
    return User::withCount([
        'tasks as completed_tasks' => function ($query) use ($validated) {
            $query->where('status', 'Completed')
                  ->whereBetween('updated_at', [$validated['start_date'], $validated['end_date']]);
        }
    ])->get();  // Return all users with their completed task count
}

}
