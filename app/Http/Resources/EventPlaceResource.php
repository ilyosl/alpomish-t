<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventPlaceResource extends JsonResource
{
    protected $rangeArray;
    private $rangeValue = 0;

     public function __construct($resource, $range = [])
    {
        $this->rangeArray = $range;

        parent::__construct($resource);
    }
    public function getRangeVal($price){
        if(is_array($this->rangeArray)){
            foreach ($this->rangeArray as $range){
                if($range['price'] == $price){
                    $this->rangeValue = $range['range'];
                }
            }
        }
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "number"=>$this->place,
            "row"=>$this->row,
            "block_name"=>$this->block_name,
            "price"=>$this->price,
            "range"=> $this->getRangeVal($this->price),
            "price_range"=> $this->range,
            "event_time"=>$this->event_time,
            "event_date"=>$this->event_date,
            "status"=>$this->status
        ];
    }
}
