<?php


namespace App\Services;


use App\Http\Resources\EventResource;
use App\Models\Events;
use App\Models\EventTime;
use Illuminate\Support\Facades\Validator;

class EventService
{
    public function addEvent($data) {

        $event = Events::create($data);
        foreach ($data['eventDate'] as $eventD){
            $eventD['event_id'] = $event->id;
            $this->createEventDate($eventD);
        }
        return new EventResource($event);
    }
    public function listEvents(){
        return EventResource::collection(Events::get());
    }
    private function createEventDate($eventDates){
        $validator = Validator::make($eventDates, [
            'eventDate' => 'required',
            'eventTime' => 'required',
            'event_id' => 'exists:App\Models\Events,id',
            'status'=>'numeric'
        ]);

        return EventTime::create($validator->validated());
    }
}
