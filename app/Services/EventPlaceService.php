<?php

namespace App\Services;

use App\Models\EventPlaceModel;

class EventPlaceService
{
    public function getPlace($data){

        $place = EventPlaceModel::where([
            'block_name'=>$data['block_name'],
            'event_id'=>$data['event_id'],
            'event_time'=>$data['event_time'],
            'event_date'=>$data['event_date']
        ])->orderby('row', 'asc')->orderby('place','asc')->get();

        return $place;
    }
}
