<?php


namespace App\Services;


use App\Http\Resources\EventResource;
use App\Models\Events;

class EventService
{
    public function addEvent($data) {

        $event = Events::create($data);

        return new EventResource($event);
    }
}
