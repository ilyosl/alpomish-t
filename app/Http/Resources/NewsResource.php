<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'title'=>$this->title,
            'short_text'=>$this->short_text,
            'desc'=>$this->desc,
            'status'=>$this->status,
            'image'=>$this->image,
            'created_at'=>date('d.m.Y H:i:s', strtotime($this->created_at))
        ];
    }
}
