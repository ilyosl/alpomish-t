<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IceSubsResource extends JsonResource
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
            'id'=>$this->id,
            'name_subs'=>$this->name_subs,
            'price'=>$this->price,
            'status'=>$this->status
        ];
    }
}
