<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickModel extends Model
{
    use HasFactory;
    protected $table = 'click';

    protected $fillable = [
        'click_trans_id',
        'service_id',
        'click_paydoc_id',
        'action',
        'error',
        'merchant_confirm_id',
        'amount',
        'merchant_trans_id',
        'error_note',
        'sign_time',
        'sight_string',
    ];
}
