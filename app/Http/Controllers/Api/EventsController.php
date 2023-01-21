<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Events;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store','destroy','update']);
    }
    public function index(EventService $service) {
        $events = $service->listEvents();
        return response($events);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AddEventRequest $request
     * @return EventResource
     */
    public function store(AddEventRequest $request, EventService $service): EventResource{
        $data = $request->validated();

        return $service->addEvent($data);
    }

    public function show(Events $event){
        return response(new EventResource($event));
    }

    public function update(){

    }

    public function destroy() {

    }
}
