<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IceSubsModel extends Model
{
    use HasFactory;
    protected $table = 'ice_subs';

    protected $fillable = ['name_subs','price','status'];
}
