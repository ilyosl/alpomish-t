<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayTransModel extends Model
{
    use HasFactory;
    protected $table = 'pay_trans';

    protected $fillable = [
        'pay_time',
        'stat',
        'reason',
        'pay_id',
        'pay_amount',
        'pay_account',
    ];
}
