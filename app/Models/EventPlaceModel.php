<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPlaceModel extends Model
{
    use HasFactory;
    protected $table = 'event_place';

    protected $fillable = [
        'place','row','event_id',
        'price','block_name','eventTime','eventDate',
        'status'
    ];
}
