<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = ['user_id','first_name','last_name','email','phone','status','sell_date'];
}
