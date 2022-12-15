<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEventRequest;
use App\Http\Resources\EventResource;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index() {

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

    public function show(){

    }

    public function update(){

    }

    public function destroy() {

    }
}
