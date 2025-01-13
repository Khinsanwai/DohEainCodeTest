<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $query = Event::query();

    //     if ($request->filled('date_from') && $request->filled('date_to')) {
    //         $query->whereBetween('event_date', [$request->date_from, $request->date_to]);
    //     }

    //     if ($request->filled('category')) {
    //         $query->where('category', $request->category);
    //     }

    //     return response()->json($query->get());
    // }
    public function index()
    {
        $events = Event::all(); // Retrieve all events from the database
        return response()->json($events);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'category' => 'required|string',
        ]);

        $event = Event::create($request->all());
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'event_date' => 'date',
            'category' => 'string',
        ]);

        $event->update($request->all());
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
