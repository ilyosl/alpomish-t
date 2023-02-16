<?php

namespace App\Admin\Controllers;


use App\Models\BlocksModel;
use App\Models\EventPlaceModel;
use App\Models\Events;
use App\Services\EventPlaceService;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;


class PlaceController extends \App\Http\Controllers\Controller
{
    public function index(Content $content, Request $request){
        $eventId = $request->get('eventId');
        $eventTitle = 'Название мероприятие: ';
        if($eventId){
            $event = Events::query()->with('eventTimes')->where('id', intval($eventId))->first();
        }
        $placePath = $this->Places();

        return $content
            ->title('Управления местами')
            ->description($eventTitle.$event->title)
            ->view('admin.place', ['path'=> $placePath,'event'=>$event]);
    }

    public function Places(){
        $placePath = BlocksModel::query()->orderBy('sort_svg')->get();
        return $placePath;
    }
    public function view(Request $request, Content $content, EventPlaceService $service){
        $data = [
            'event_id'=>$request->get('eventId'),
            'block_name'=>$request->get('blockName'),
            'event_time'=>$request->get('eventTime'),
            'event_date'=>$request->get('eventDate'),
        ];

        $places = $service->getPlace($data);
        $tmpPlace = BlocksModel::query()->where('name_block',$data['block_name'])->first();
        $convert = $service->convertPlaces($tmpPlace, $places);
        $event = Events::query()->with('eventTimes')->where('id', $data['event_id'])->first();

        return $content->title('Управления местами')
            ->view('admin.block_page',compact("places", 'event', 'tmpPlace','convert'));
    }
    public function setTicket(Request $request){
//        dd($request->post());
        $tickets = $request->post('tickets');
        $blockName = $request->post('block_name');
        $eventId = $request->post('event_id');
        $eventDate = $request->post('eventDate');
        $eventTime = $request->post('eventTime');
        $status = $request->post('status');
        $costTicket = $request->post('costTicket');
        if(!empty($tickets)){
            foreach ($tickets as $key => $ticket){
                if($ticket){
                    $joyqator = explode(',', $ticket);
                    if( isset($joyqator[1])) {
                        $checkPlace = EventPlaceModel::query()->where([
                            'event_id' => $eventId,
                            'block_name' => $blockName,
                            'event_time' => $eventTime,
                            'event_date' => $eventDate,
                            'place' => $joyqator[1],
                            'row' => $joyqator[0],
                        ])->first();
                        if (empty($checkPlace)) {
                            EventPlaceModel::query()->create([
                                'event_id' => $eventId,
                                'block_name' => $blockName,
                                'event_time' => $eventTime,
                                'event_date' => $eventDate,
                                'place' => $joyqator[1],
                                'row' => $joyqator[0],
                                'price'=>$costTicket,
                                'status'=>$status
                            ]);
                        }else{
                            $checkPlace->status = $status;
                            $checkPlace->price = $costTicket;
                        }
                    }
                }

            }
            admin_success('Успешно добавлено');
            return back();
        }
    }
}
