<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatokQrcodeModel extends Model
{
    protected $table =  'katokQrcode';
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['qrcode','price','time','startDate','endDate','status'];
}
