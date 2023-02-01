<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AdditionalService
{
    public function getStaticByDay(){
        $query = "SELECT sum(price*count) as price_sum, type, count(id) as ticket_count
	FROM public.\"additional_service\" Where date_trunc('day', sell_date) = '".date('Y-m-d', time())."' group by type";
        $info = DB::select($query);
        //DB::table('katokQrcode')->where('type',$type)->whereDay('sell_date', date('d', time()))->whereMonth('sell_date',date('m', time()))->get();
        return $info;
    }
}
