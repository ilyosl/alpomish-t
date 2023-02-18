<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventPlaceModel extends Model
{
    use HasFactory;
    protected $table = 'event_place';

    protected $fillable = [
        'place','row','event_id',
        'price','block_name','event_time','event_date',
        'status'
    ];

    public static function getPriceRange($price = 0){
        $query = 'select  price, ROW_NUMBER () OVER (ORDER BY price) as range from "event_place" group by "event_place".price;';
        $info = DB::select($query);
        return $info;
    }
    public function qrcode(){
        return $this->hasOne(TicketQrcodeModel::class, 'event_place_id');
    }
}
