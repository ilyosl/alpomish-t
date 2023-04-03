<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdditionalServiceModel extends Model
{
    use HasFactory;
    protected $table = 'additional_service';

    protected $fillable = ['type','payment','price','sell_date','count','user_id'];

    public function getStaticByDay(){
        $query = "SELECT sum(price*count) as price_sum, type, count(id) as ticket_count
	FROM public.\"additional_service\" Where date_trunc('day', sell_date) = '".date('Y-m-d', time())."' group by type";
        $info = DB::select($query);
        //DB::table('katokQrcode')->where('type',$type)->whereDay('sell_date', date('d', time()))->whereMonth('sell_date',date('m', time()))->get();
        return $info;
    }


}
