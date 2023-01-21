<?php

namespace App\Services;

use App\Models\EventPlaceModel;

class EventPlaceService
{
    public function getPlace($data){

        $place = EventPlaceModel::where([
            'block_name'=>$data['block_name'],
            'eventTime'=>$data['event_id'],
            'eventDate'=>$data['event_time'],
            'event_date'=>$data['event_date']
        ])->get();

        return $place;
    }
}
