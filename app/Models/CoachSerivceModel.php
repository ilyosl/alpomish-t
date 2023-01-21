<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSerivceModel extends Model
{
    use HasFactory;
    protected $table = 'coach_service';
    protected $fillable = ['type','price','time_coach','sell_date'];
}
