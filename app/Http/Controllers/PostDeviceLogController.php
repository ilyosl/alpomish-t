<?php

namespace App\Http\Controllers;

use App\Models\PostDeviceLogModel;
use App\Services\katokQrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostDeviceLogController extends Controller
{
    public function index(Request $request, katokQrcode $service ){
//        dd($request);
        if(isset($_POST['event_log']) && $data = $_POST['event_log']){
            $res = json_decode($data);
            if($res->AccessControllerEvent->subEventType == 9){
                $card = $res->AccessControllerEvent->cardNo;
                if($service->checkStatus($card, 0) && $service->checkEnter($res->ipAddress)){
                    $service->changeKatokData($card, 'open', 1, $res->ipAddress);
                }elseif($service->checkStatus($card, 1) && $service->checkExit($res->ipAddress)){
                    $service->changeKatokData($card, 'open', 2, $res->ipAddress);
                }
            }
            if($res){
               $saveData =  PostDeviceLogModel::create([
                    'device_ip'=>$res->ipAddress,
                    'comingDate' => date('Y-m-d H:i:s', time()),
                    'log' => $data
                ]);
            }
//            return $saveData;
        }
    }
    public function listData()
    {
        $query = "select * from \"postDeviceLog\"
         where log #> '{AccessControllerEvent, subEventType}' = '9'
         order by id desc";
        $data = DB::select($query);
        echo "<pre>";
        print_r($data);
    }
    public function view(Request $request){
        dd($request->post());
        Log::log('post', 'post', $request->post());

        return ['success'=>1];
    }
}
