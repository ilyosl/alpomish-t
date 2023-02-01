<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdditionalServiceModel;
use App\Services\AdditionalService;
use App\Services\katokQrcode;
use Illuminate\Http\Request;

class AdditionalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(katokQrcode $service):array
    {
        $res = $service->getStaticServiceByDay(1);

        return $res;
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
    public function store(Request $request):array
    {
        $data = $request->post();
        $adding = [];
        if($data){
            foreach ($data as $service){
                $adding[] = AdditionalServiceModel::create([
                    'type'=>$service['type'],
                    'price'=>$service['price'],
                    'payment'=>$service['payment'],
                    'sell_date'=>date('Y-m-d H:i:s', time()),
                    'count'=>$service['count']
                ]);
            }
            return ['success'=>1, 'data'=>$adding];
        }else{
            return  ['success'=>0];
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
