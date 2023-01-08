<?php

namespace App\Http\Controllers;

use App\Models\PostDeviceLogModel;
use Illuminate\Http\Request;

class PostDeviceLogController extends Controller
{
    public function index(Request $request ){
//        dd($request);
        if(isset($_POST['event_log']) && $data = $_POST['event_log']){
            $res = json_decode($data);

            if($res){
                PostDeviceLogModel::create([
                    'device_ip'=>$res->ipAddress,
                    'comingDate' => date('d.m.Y H:i', time()),
                    'log' => $data
                ]);
            }
        }
    }
}
