<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersRequest;
use App\Http\Resources\OrdersResource;
use App\Models\OrderEventModel;
use App\Models\OrdersModel;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        $orders = OrdersModel::with('tickets')->where('user_id', $user)->get();
        return OrdersResource::collection($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrdersRequest $request, OrderService $service):array
    {
        $data = $request->validated();
        $tickets = $data['tickets'];
        unset($data['tickets']);
        $data['user_id'] = auth()->user()->id;

        try {
            $data['summ'] = $service->getCostTickets($tickets);
            $data['count_tickets'] = count($tickets);
            $order = OrdersModel::create($data);
            $paymeData = [];
            if($data['payment_type'] == 'payme'){
                $paymeData = [
                    'amount'=>$order->summ,
                    'order_id' =>$order->id,
                    "merchant_id"=>"63e236afa52727e621b30c3c"
                ];
            }
            foreach ($tickets as $key => $value){
                OrderEventModel::create([
                    'order_id'=>$order->id,
                    'event_place_id'=>$value
                ]);
            }
            return ['success'=>1, 'payme'=>$paymeData];
        }catch (\Exception $e){
            abort(400, $e);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $orderEvents = DB::table('order_event')->select('event_place_id')
//            ->where(['order_id'=> $id])->get();
//        $tickets = [];
//        foreach ($orderEvents as $orderEvent){
//            $tickets[]=$orderEvent->event_place_id;
//        }
////        dd($tmpTicket);
////        $tickets = implode(',',$tmpTicket);
//
//        $update =  DB::table('event_place')
//            ->whereIn('id', $tickets)
//            ->update(['status'=>2]);
//
//        return  $update;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
