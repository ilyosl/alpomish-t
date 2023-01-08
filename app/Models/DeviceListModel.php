<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceListModel extends Model
{
    protected $table = 'deviceList';
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['ip_address','type'];
}
