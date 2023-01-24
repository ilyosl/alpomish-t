<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventPlaceCollection extends ResourceCollection
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
                if($range->price == $price){
                    return $this->rangeValue = $range->range;
                }
            }
        }
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "count_place"=>$this->collection->map(function($n){
                return [
                    "number"=>$n->place,
                    "row"=>$n->row,
                    "block_name"=>$n->block_name,
                    "price"=>$n->price,
                    "range"=> $this->getRangeVal($n->price),
                    "event_time"=>$n->event_time,
                    "event_date"=>$n->event_date,
                    "status"=>$n->status
                ];
            })
        ];
    }
}
