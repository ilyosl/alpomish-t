<?php

namespace App\Admin\Forms;

use App\Models\EventPlaceModel;
use App\Models\Events;
use App\Models\EventTime;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class EventPlaceForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Add place form';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $event_id = $request->post('event_id');
        $event_date = $request->post('event_date');
        $event_time = $request->post('event_time');
        $block_name = $request->post('block_name');
        $row_number = $request->post('row_number');
        $price = $request->post('price');
        $placeArray = explode('-', $request->post('place_numbers'));
        for($i=$placeArray['0']; $i<=$placeArray['1']; $i++){
            EventPlaceModel::create([
                "place"=>$i,
                "row"=>$row_number,
                "block_name" => $block_name,
                "event_id" => $event_id,
                "event_date"=> $event_date,
                "event_time"=> $event_time,
                "price"=>$price,
                "status"=>0
            ]);
        }
        admin_success('Processed successfully.');
        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $request = Request::capture();
        $eventId = $request->get('event');
        if($eventId){
            $event = Events::with('eventTimes')->where(['id'=>intval($eventId)])->first();
//            dd($event);
            if(isset($event->eventTimes[0]->eventDate)){
                $this->text('eventName', 'Мероприятия')->default($event->title)->disable();
                $this->text('eventDate', 'Дата')->default($event->eventTimes[0]->eventDate)->disable();
                $this->text('eventTime', 'Время')->default($event->eventTimes[0]->eventTime)->disable();
                $this->hidden('event_id','')->default($event->id);
                $this->hidden('event_date','')->default($event->eventTimes[0]->eventDate);
                $this->hidden('event_time','')->default($event->eventTimes[0]->eventTime);
                $this->text('block_name', 'Название блока')->rules('required');
                $this->text('row_number', 'Номер ряда')->rules('required');
                $this->text('place_numbers','Место')->placeholder('example: 1-18')->rules('required');
                $this->text('price','Стоимость билета')->rules('required');
            }else{
                $this->disableSubmit();
                $this->disableReset();
                admin_error('event time error');
            }
        }
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'name'       => 'John Doe',
            'email'      => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
