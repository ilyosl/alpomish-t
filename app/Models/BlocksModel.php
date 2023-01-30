<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlocksModel extends Model
{
    use HasFactory;

    protected $table = 'blocks';

    protected $fillable = ['name_block','count_place','count_rows','place_info'];
}
