<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlocksModel;
use App\Models\Events;
use App\Services\EventPlaceService;

use Barryvdh\DomPDF\Facade\Pdf;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class KassirController extends Controller
{
    public function index(Content $content){
//        dd($content);
        $events = Events::query()->where(['status'=>1])->get();
        return $content->title('Кабинет кассира')
            ->description('Список мероприятий')
            ->view('admin.cashier.index', compact('events'));
    }
    public function view($event, Content $content){
//        dd($event);
        $model = Events::query()->with('eventTimes')->where('id',$event)->first();
        $placePath = BlocksModel::query()->orderBy('sort_svg')->get();
        $content->breadcrumb(
            ['text' => 'Список мероприятий', 'url' => '/cashier'],
            ['text' => 'Места'],
        );
        return $content->title('Выберите месту')->view('admin.cashier.place',['path'=>$placePath,'event'=>$model]);
    }
    public function place(Request $request, Content $content, EventPlaceService $service){
        $data = [
            'event_id'=>$request->get('eventId'),
            'block_name'=>$request->get('blockName'),
            'event_time'=>$request->get('eventTime'),
            'event_date'=>$request->get('eventDate'),
        ];
//        dd($data);
        $places = $service->getPlace($data);
        $tmpPlace = BlocksModel::query()->where('name_block',$data['block_name'])->first();
        $convert = $service->convertPlaces($tmpPlace, $places);
        $event = Events::query()->with('eventTimes')->where('id', $data['event_id'])->first();
        $content->breadcrumb(
            ['text' => 'Список мероприятий', 'url' => '/cashier'],
            ['text' => 'Места', 'url' => '/cashier/'.$data['event_id'].''],
            ['text'=>'Управления']
        );
        return $content->title('Управления местами')
            ->view('admin.cashier.page',compact("places", 'event', 'tmpPlace','convert'));
    }
    public function ticket()
    {
      /*  $pdf = PDF::loadView('admin.cashier.ticketPdf', [
            'title' => 'CodeAndDeploy.com Laravel Pdf Tutorial',
            'description' => 'This is an example Laravel pdf tutorial.',
            'footer' => 'by <a href="https://codeanddeploy.com">codeanddeploy.com</a>'
        ]);

        return $pdf->download('sample.pdf');*/
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }
}
