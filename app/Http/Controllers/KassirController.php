<?php

namespace App\Http\Controllers;

use App\Http\Requests\QrcodeRequest;
use Illuminate\Http\Request;

class KassirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return view('kassir.index');
    }
    public function getInfoByQr(QrcodeRequest $request){
        $data = $request->validated();
        return response(['qrcode'=>$data]);
    }
}
