<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('event');
    }

    public function listEvent(Request $request)
    {
        $start = date('y-m-d', strtotime($request->start));
        $end = date('y-m-d', strtotime($request->end));

        $event = Event::where('start_date', '>=', $start)
        ->where('end_date', '<=', $end)->get()
        ->map(fn ($item) => [
        'id'=> $item->id,
        'title' => $item->title, 
        'start' => $item->start_date, 
        'end' => date('y-m-d', strtotime($item->end_date. '+1 days')), 
        'category' => $item->category
    ]);
        return response()->json($event);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('event-form', ['data' => $event, 'action' => route('events.store')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request, Event $event)
    {
       return $this->update($request, $event);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('event-form', ['data' => $event, 'action' => route('events.update', $event->id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->title = $request->title;
        $event->category = $request->category;

        $event->save();

        return response()->json([
            'status' => 'success',
            'massage' => 'Save data Successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
