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
    public function conToArray($place){
        $places = [];
        for ($arr = $place[0]; $arr<=$place[1]; $arr++){
            array_push($places, (int)$arr);
        }
        return $places;
    }
    public function convertPlaces($blocks, $eventPlace){
//        dd($eventPlace);
        $rows = explode('-', $blocks->count_place);
        $placeArray = explode(',', $blocks->count_rows);
        $data = [];
        for ($i=$rows[0]; $i <= $rows[1]; $i++){
            $place = explode('-', $placeArray[$i-1]);
            $places = $this->conToArray($place);
//            dd($places);
            foreach ($eventPlace as $ep){
                if($ep->row == $i){

                    $data[$i][$ep->place]= [
                        'status'=>$ep->status,
                        'price'=>$ep->price,
                        'exists'=>1
                    ];
                    $places = array_diff($places, [$ep->place]);
                }
            }

            foreach ($places as $key => $value){

                $data[$i][$value]= [
                    'status'=>0,
                    'price'=>0,
                    'exists'=>0
                ];
            }
        }
        return $data;
    }
}
