<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForKatokServiceModel extends Model
{
    use HasFactory;
    protected $table = 'application_for_katok_services';

    protected $fillable = ['katok_service_id','first_name','last_name','phone','comment','status'];

    public function katok(){
        return $this->belongsTo(KatokServiceModel::class, 'katok_service_id');
    }
}
