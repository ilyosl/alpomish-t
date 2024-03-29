<?php

namespace App\Services;

use App\Actions\openDoor;
use App\Models\DeviceListModel;
use App\Models\KatokQrcodeModel;
use Carbon\Carbon;
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
    public function getDateRangeStatAdd($dateFrom,$dateTo){

        $query = "select  sum(price*count) as price_sum, date(sell_date) as sell_date
            from \"additional_service\"
            where sell_date >= '".$dateFrom."' and sell_date <= '".$dateTo."'
            GROUP BY date(sell_date) ORDER BY sell_date ASC";
        $qrCode = DB::select($query);

        $resData = [];
        $priceData = [];
        if($qrCode){
            foreach ($qrCode as $code){
                $resData[] = $code->sell_date;
                $priceData[] = ['t'=> $code->sell_date, 'y'=>$code->price_sum];
            }
        }
        return ['date'=>$resData, 'price'=>$priceData];
    }
    public function getDateRangeStat($dateFrom,$dateTo){

         $query = "select sum(price) as price, date(sell_date) as sell_date
            from \"katokQrcode\"
            where sell_date >= '".$dateFrom."' and sell_date <= '".$dateTo."'
            GROUP BY date(sell_date) ORDER BY sell_date ASC";
        $qrCode = DB::select($query);

        $resData = [];
        $priceData = [];
        if($qrCode){
            foreach ($qrCode as $code){
                $resData[] = $code->sell_date;
                $priceData[] = ['t'=> $code->sell_date, 'y'=>$code->price];
            }
        }
        return ['date'=>$resData, 'price'=>$priceData];
    }
    public function getStaticByType(){
        $query = "SELECT sum(price) as price_sum, type, count(id) as ticket_count
	FROM public.\"katokQrcode\" group by type";
        $info = DB::select($query);
        $typeList = [];
        $priceList = [];
        foreach ($info as $item){
            $typeList[]=$item->type;
            $priceList[]=$item->price_sum;
        }
        return ['type'=>$typeList,'price'=>$priceList];
    }
    public function serializeDayStatic(){
        $data = $this->getStaticByDay(false);

        $typeList = [];
        $priceList = [];
        $countTicket = [];
        foreach ($data as $item){
            $typeList[]=$item->type;
            $priceList[]=$item->price_sum;
            $countTicket[]=$item->ticket_count;
        }
        return ['type'=>$typeList,'price'=>$priceList,'countTicket'=>$countTicket];
    }
    public function getStaticByDay($withKass = true){
        $kassId = '';
        if($withKass){
            $kassId = " user_id= ".auth()->user()->id." and ";
        }
        $query = "SELECT sum(price) as price_sum, type, count(id) as ticket_count
	FROM public.\"katokQrcode\" Where ".$kassId." date_trunc('day', sell_date) = '".date('Y-m-d', time())."' group by type";
        $info = DB::select($query);
            //DB::table('katokQrcode')->where('type',$type)->whereDay('sell_date', date('d', time()))->whereMonth('sell_date',date('m', time()))->get();
        return $info;
    }
    public function getStaticServiceByDay($type = 0){
        $query = "SELECT sum(price*count) as price_sum, sum(count) as count, payment, count(id) as service_count
	FROM public.\"additional_service\" Where user_id= ".auth()->user()->id." and date_trunc('day', sell_date) = '".date('Y-m-d', time())."' and type='".$type."' group by payment";
        $info = DB::select($query);
        //DB::table('katokQrcode')->where('type',$type)->whereDay('sell_date', date('d', time()))->whereMonth('sell_date',date('m', time()))->get();
        return $info;
    }
}
