<?php

namespace App\Admin\Controllers;

use App\Services\katokQrcode;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\InfoBox;
use Illuminate\Http\Request;
use function Termwind\render;

class KatokStaticsController extends \App\Http\Controllers\Controller
{
    public function index(Content $content, katokQrcode $service, Request $request){
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        if(empty($dateFrom)){
            $dateFrom = '2023-01-15';
        }
        if(empty($dateTo)){
            $dateTo = date('Y-m-d', time());
        }
        $dataKatok = $service->getDateRangeStat($dateFrom,$dateTo);
        $staticType = $service->getStaticByType();
        $dayStatic = $service->serializeDayStatic();
        $kataDate = [
            'date'=> json_encode($dataKatok['date']),
            'price'=> json_encode($dataKatok['price']),
        ];
        $staticKatok = [
            'type'=> json_encode($staticType['type']),
            'price'=> json_encode($staticType['price']),
        ];
        $staticKatokDay = [
            'type'=> json_encode($dayStatic['type']),
            'price'=> json_encode($dayStatic['price']),
            'countTicket'=> json_encode($dayStatic['countTicket']),
        ];


//        dd($dayStatic);
//        echo $kataDate['price']; die;
        $onlineKatok = new InfoBox('Сейчас на катке', 'map-o', 'aqua', null, '1024');
        $sellTickets = new InfoBox('Продана билетов', 'money', 'green', null, '1024');
        $sellTicketsToday = new InfoBox('Продана на сегодня', 'bank', 'yellow', null, '1024');
        return $content->title('Статистика катка')
            ->view('admin.katok', [
                'onlineKatok'=>$onlineKatok->render(),
                'sellTickets'=>$sellTickets->render(),
                'sellTicketsToday'=>$sellTicketsToday->render(),
                'data'=>$kataDate,
                'priceType'=>$staticKatok,
                'priceTypeDay'=>$staticKatokDay,
            ]);
    }
}
