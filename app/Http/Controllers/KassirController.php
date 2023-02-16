<?php

namespace App\Http\Controllers;

use App\Actions\openDoor;
use App\Http\Requests\QrcodeRequest;
use App\Models\BlocksModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KassirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(openDoor $action){
        $placePath = BlocksModel::query()->orderBy('sort_svg','asc')->get();
        return view('admin.place', ['path'=> $placePath]);
    }
    public function getInfoByQr(QrcodeRequest $request){
        $data = $request->validated();
        return response($data);
    }

    public function addPerson(){
        $personId = 123;
        $data = [
            'UserInfo'=>[
            'employeeNo'=> $personId,
            'name'=>'qrcode',
            'userType' => 'normal',
            'Valid' =>[
                'enable' => true,
                'beginTime' => '2022-02-01T01:00:00',
                'endTime' => '2023-02-01T01:00:00',
                'timeType' => 'local'
            ],
            'doorRight'=> 1,
            'RightPlan' => [
                [
                    'doorNo' => 1,
                    'planTemplateNo' => 1
                ]
            ]
            ]
        ];
//        dd(json_encode($data));
        $res = Http::dd()->withDigestAuth('admin','12345678a')->post('http://192.168.0.33/ISAPI/AccessControl/UserInfo/Record?format=json', $data);
//        dd($res);
        $card = $this->addCard($personId);
        return response($res, $card);
    }
    public function addCard($personId) {
        $res = Http::withDigestAuth('admin','12345678a')->post('http://192.168.0.33/ISAPI/AccessControl/CardInfo/Record?format=json',[
                'CardInfo' => [
                    'employeeNo' => $personId,
                    'cardNo' => 1234567890,
                    'deleteCard' => null,
                    'cardType' => 'normalCard',
                    'leaderCard' => '',
                    'checkCardNo' => false,
                    'checkEmployeeNo' =>true,
                    'addCard' => false
                ]
        ]);
        return $res;
    }
}
