<?php

namespace App\Services;

use App\Actions\openDoor;
use App\Models\DeviceListModel;
use App\Models\KatokQrcodeModel;
use Exception;
use Illuminate\Support\Facades\DB;

class katokQrcode
{

    public function changeKatokData($qrcode, $action, $status, $ipaddress){
        try {
            if($status == 1){
               $changeINfo =  KatokQrcodeModel::where(['qrcode' => $qrcode])->first();
               $changeINfo->startDate =  date('Y-m-d H:i:s', time());
               $changeINfo->finishDate = date('Y-m-d H:i:s', (time()+$changeINfo->time*60));
               $changeINfo->status = $status;
               $changeINfo->save();
            }elseif($status == 2){
                KatokQrcodeModel::where('qrcode', $qrcode)->update([
                'exitDate'=> date('Y-m-d H:i:s', time()),
                    'status' => $status
                ]);
            }

            sleep(1);
            $openDoor = new openDoor();
            $openDoor->actionDoor($action, $ipaddress);
        }catch (Exception $e){

        }

    }
    public function checkStatus($qrcode, $status){
        $katok = KatokQrcodeModel::where(['qrcode'=>$qrcode, 'status'=>$status])->first();
        if($katok)
            return true;
        else
            return false;
    }
    public function getByQrcode($qrcode){
        $katok = KatokQrcodeModel::where(['qrcode'=>$qrcode])->orderBy('id','DESC')->first();

        return $katok;
    }
    public function checkEnter($ipaddress){
        $device = DeviceListModel::where(['ip_address'=>$ipaddress])->first();
        if($device->type == 0){
            return true;
        }else{
            return false;
        }

    }
    public function checkExit($ipaddress){
        $device = DeviceListModel::where(['ip_address'=>$ipaddress])->first();
        if($device->type == 1){
            return true;
        }else{
            return false;
        }
    }
    public function getStaticByDay($type =''){
        $query = "SELECT sum(price) as price_sum, type, count(id) as ticket_count
	FROM public.\"katokQrcode\" Where date_trunc('day', sell_date) = '".date('Y-m-d', time())."' group by type";
        $info = DB::select($query);
            //DB::table('katokQrcode')->where('type',$type)->whereDay('sell_date', date('d', time()))->whereMonth('sell_date',date('m', time()))->get();
        return $info;
    }
}
