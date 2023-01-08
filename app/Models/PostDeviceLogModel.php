<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDeviceLogModel extends Model
{
    protected $table = 'postDeviceLog';
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['device_ip','comingDate', 'log'];
}
