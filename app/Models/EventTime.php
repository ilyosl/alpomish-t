<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTime extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['eventDate','eventTime','event_id','status'];

    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
}
