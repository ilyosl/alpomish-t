<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatokServiceModel extends Model
{
    use HasFactory;
    protected $table = 'katok_service';

    protected $fillable = ['name','work_week','work_time','coach_fio','img_url'];
}
