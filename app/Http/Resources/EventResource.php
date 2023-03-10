<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'id' => $this->id,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'desc'=>$this->desc,
            'image'=>env('APP_URL').'/storage/'.$this->image,
            'status'=>$this->status,
            'age_limit'=>$this->age_limit,
            'eventDate'=>EventTimeResource::collection($this->eventDate)
        ];
    }
}
