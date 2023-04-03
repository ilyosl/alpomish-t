<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSubsRequest;
use App\Http\Resources\IceSubsResource;
use App\Models\IceSubsModel;
use App\Models\OrderSubsModel;
use Illuminate\Http\Request;

class IceSubsController extends Controller
{
    public function list(){
        return IceSubsResource::collection(IceSubsModel::query()->get());
    }
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
    public function store(OrderSubsRequest $request)
    {
        $data = $request->validated();
        $addOrder = OrderSubsModel::query()->create([
            'ice_subs_id'=>$data['type'],
            'payment'=>$data['payment'],
            'price'=>$data['price'],
            'count_ticket'=>$data['count_ticket'],
            'status'=>2,
            'sell_date'=>date('Y-m-d H:i', time())
        ]);

        return $addOrder;
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
