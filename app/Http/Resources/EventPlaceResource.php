<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventPlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "place"=>$this->place,
            "row"=>$this->row,
            "block_name"=>$this->block_name,
            "price"=>$this->price,
            "event_time"=>$this->eventTime,
            "event_date"=>$this->eventDate,
            "status"=>$this->status
        ];
    }
}
