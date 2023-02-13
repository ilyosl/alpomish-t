<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketQrcodeModel extends Model
{
    use HasFactory;
    protected $table = 'ticket_qrcode';

    protected $fillable = [
        'event_place_id',
        'status',
        'qrcode'
    ];
}
