<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSubsModel extends Model
{
    use HasFactory;
    protected $table = 'order_subs';

    protected $fillable = ['ice_subs_id','payment','sell_date','price','status','count_ticket'];
}
