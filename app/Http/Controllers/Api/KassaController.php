<?php

namespace App\Http\Controllers\Api;

use App\Actions\openDoor;
use App\Enum\KatokTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\KatokQrcodeModel;
use App\Services\katokQrcode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KassaController extends Controller
{
    public function getData(Request $request) {
        $res = $request->post('data');
        $type = $request->post('type');
//        return  $request->post('data');
        foreach ($res['data'] as $qr){
            $time = 0;
            if($qr['time'] == 35000 || $qr['time'] == 30000){
                $time = 30;
            }elseif($qr['time'] == 70000 || $qr['time'] == 60000){
                $time = 60;
            }
            $checkQrcode = KatokQrcodeModel::where(['status'=>0,'qrcode'=>$qr['qrcode']])->whereDate('sell_date', Carbon::today())->first();
            if(empty($checkQrcode)) {
                $add = KatokQrcodeModel::create([
                    'qrcode' => $qr['qrcode'],
                    'price' => $qr['time'],
                    'time' => $time,
                    'sell_date' => date('Y-m-d H:i:s', strtotime("now")),
                    'startDate' => date('Y-m-d H:i:s', strtotime("now")),
                    'finishDate' => date('Y-m-d H:i:s', strtotime("+" . $time . " minutes")),
                    'exitDate' => date('Y-m-d H:i:s', strtotime("+" . $time . " minutes")),
                    'status' => 0,
                    'type' => $res['type']
                ]);
            }
        }
        return response(['success'=>1]);
    }
    public function checkQrcode(Request $request){
        $qrcode = $request->post('qrcode');
        if($qrcode){
            $isExists = KatokQrcodeModel::where([ 'qrcode'=>$qrcode])->orderBy('id','DESC')->first();
            if($isExists){
                return ['success'=>1, 'data'=>$isExists];
            }else{
                return ['success'=>0];
            };
        }
    }
    public function countEnter(Request $request){
//        $qrcode = $request->post('qrcode');
        $status = $request->post('status');
        if($status){
            $isExists = DB::table('katokQrcode')->where(['status'=> $status])->whereDate('sell_date', Carbon::today())->get();
            //$isExists = KatokQrcodeModel::where(['status'=> $status])->whereDate(['sell_date', Carbon::today()])->get();
            if($isExists){
                return ['success'=>1, 'data' => $isExists, 'count'=>count($isExists)];
            }else{
                return ['success' =>0];
            }
        }
    }
    public function getFeedKatok(Request $request) {
        $status = $request->query('status');
        $is_read = $request->query('is_read');
        $isReadFirst = KatokQrcodeModel::where(['status'=>$status,'is_read'=>$is_read])->first();
        if($isReadFirst){
            $isReadFirst->is_read = $is_read+1;
            $isReadFirst->save();
            $to_time = strtotime($isReadFirst->exitDate);
            $from_time = strtotime($isReadFirst->finishDate);

            $diffTime = round(abs($to_time - $from_time) / 60);
            $isReadFirst->diffTime = $diffTime;
            return $isReadFirst;
        }else{
            return ['success'=>0, 'error'=>'not found'];
        }

    }
    public function extendQrcode(Request $request, katokQrcode $service){
        $qrcode = $request->post('qrcode');
        $type = $request->post('type');
        $time = $request->post('time');
        $price = $request->post('price');
        $katok = $service->getByQrcode($qrcode);
        if($katok->status == 1 || $katok->status == 2){
            $finD = strtotime($katok->finishDate)+($time*60);
            $addextend = KatokQrcodeModel::create([
                'qrcode' => $qrcode,
                'price' => $price,
                'time'=> $time,
                'sell_date'=>date('Y-m-d H:i:s', time()),
                'startDate'=>$katok->finishDate,
                'finishDate'=>date('Y-m-d H:i:s', $finD),
                'exitDate'=>date('Y-m-d H:i:s', $finD),
                'status' => 1,
                'type'=> $type,
                'parent_id' => $katok->id
            ]);
            $katok->status = 3;
            $katok->save();
            return ['success'=>1, 'data' => $addextend];
        }else{
            return  ['success'=>0];
        }
    }
    public function opendDoor(Request $request, openDoor $action){
        $ipAddress = $request->post('ipaddress');
        $door = $request->post('status');
//        return [$ipAddress, $door];

        $response = $action->actionDoor($door, $ipAddress);
        return ['success'=>1, 'data'=>$response];
    }
    public function staticsInfo(katokQrcode $service) {
        $res = $service->getStaticByDay(KatokTypeEnum::Cash);

        return [
            'data'=>$res
        ];
    }
}
