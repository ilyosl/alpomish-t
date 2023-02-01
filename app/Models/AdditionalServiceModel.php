<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalServiceModel extends Model
{
    use HasFactory;
    protected $table = 'additional_service';

    protected $fillable = ['type','qrcode','price','sell_date','count'];


}
