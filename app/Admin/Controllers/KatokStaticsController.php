<?php

namespace App\Admin\Controllers;

use App\Services\katokQrcode;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\InfoBox;
use function Termwind\render;

class KatokStaticsController extends \App\Http\Controllers\Controller
{
    public function index(Content $content, katokQrcode $service){
        $dataKatok = $service->getDateRangeStat('2023-02-14','2023-02-21');
        $staticType = $service->getStaticByType();

        $kataDate = [
            'date'=> json_encode($dataKatok['date']),
            'price'=> json_encode($dataKatok['price']),
        ];
        $staticKatok = [
            'type'=> json_encode($staticType['type']),
            'price'=> json_encode($staticType['price']),
        ];

//        dd($staticType);
//        echo $kataDate['price']; die;
        $onlineKatok = new InfoBox('Сейчас на катке', 'map-o', 'aqua', null, '1024');
        $sellTickets = new InfoBox('Продана билетов', 'money', 'green', null, '1024');
        $sellTicketsToday = new InfoBox('Продана на сегодня', 'bank', 'yellow', null, '1024');
        return $content->title('Статистика')
            ->view('admin.katok', [
                'onlineKatok'=>$onlineKatok->render(),
                'sellTickets'=>$sellTickets->render(),
                'sellTicketsToday'=>$sellTicketsToday->render(),
                'data'=>$kataDate,
                'priceType'=>$staticKatok
            ]);
    }
}
