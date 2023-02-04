<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderEventModel extends Model
{
    use HasFactory;
    protected $table = 'order_event';

    protected $fillable = ['order_id','event_place_id'];
}
