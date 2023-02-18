<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
        'user_id','first_name','last_name',
        'email','phone','status','confirm_buy','payment_type',
        'count_tickets','summ'
    ];

    public function tickets(){
        return $this->belongsToMany(EventPlaceModel::class,
            'order_event',
            'order_id',
            'event_place_id'
        )->with('qrcode');
    }

}
