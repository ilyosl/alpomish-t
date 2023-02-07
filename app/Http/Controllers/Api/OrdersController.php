<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersRequest;
use App\Models\OrderEventModel;
use App\Models\OrdersModel;
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
        //
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
    public function store(OrdersRequest $request):array
    {
        $data = $request->validated();
        $tickets = $data['tickets'];
        unset($data['tickets']);
        $data['user_id'] = auth()->user()->id;

        try {
            $cost = DB::table('event_place')->selectRaw('sum(price) as cost')
                ->whereIn('id', $tickets)
                ->first();
            $data['summ'] = $cost->cost;
            $data['count_tickets'] = count($tickets);
            $order = OrdersModel::create($data);
            foreach ($tickets as $key => $value){
                OrderEventModel::create([
                    'order_id'=>$order->id,
                    'event_place_id'=>$value
                ]);
            }
            return ['success'=>1, 'order'=>$order];
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
        //
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
