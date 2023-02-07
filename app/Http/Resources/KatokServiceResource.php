<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KatokServiceResource extends JsonResource
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
            'name'=>$this->name,
            'work_week'=>$this->work_week,
            'work_time'=>$this->work_time,
            'coach_fio'=>$this->coach_fio,
            'img_url'=>$this->img_url
        ];
    }
}
