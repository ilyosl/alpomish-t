<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\KatokSeriviceRequest;
use App\Http\Resources\KatokServiceResource;
use App\Models\KatokServiceModel;
use Illuminate\Http\Request;

class KatokServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KatokServiceResource::collection(KatokServiceModel::query()->get());
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
    public function store(KatokSeriviceRequest $request)
    {
        $data = $request->validated();

        $file = $request->file('img_url');
        $destinationPath = env('APP_URL').'/storage/uploads/katokService/';
        $fileName = time().'_kataok_service.'.$file->getClientOriginalExtension();
        $filePath = $destinationPath.$fileName;
        $file->storeAs('uploads/katokService/', $fileName, 'public');

        $data['img_url'] = $filePath;

        $katokAdd = KatokServiceModel::create($data);

        return $katokAdd;
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
