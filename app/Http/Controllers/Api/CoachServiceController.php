<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoachServiceRequest;
use App\Models\CoachSerivceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoachServiceController extends Controller
{
    public function store(CoachServiceRequest $request){
        $coachMoney = $request->validated();
        $addInfo = CoachSerivceModel::create([
            "type"=>$coachMoney['type'],
            "price"=>$coachMoney['price'],
            "time_coach"=>$coachMoney['time_coach'],
            "sell_date" => date('Y-m-d H:i:s', time())
        ]);
        return response($addInfo);
    }
    public function getStatic(){
        $query = "SELECT sum(price) as price_sum, type, count(id) as ticket_count
	FROM public.\"coach_service\" Where date_trunc('day', sell_date) = '".date('Y-m-d', time())."' group by type";
        $info = DB::select($query);

        return response($info);
    }
}
