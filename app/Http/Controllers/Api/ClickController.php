<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function prepare(Request $request){
        $messages = array(
            0 => array("error"=>"0","error_note"=>"success"),
            1 => array("error"=>"-1","error_note"=>"SIGN CHECK FAILED!"),
            2 => array("error"=>"-2","error_note"=>"Incorrect parameter amount"),
            4 => array("error"=>"-4","error_note"=>"Транзакция ранее была подтверждена"),
            9 => array("error"=>"-9","error_note"=>"Транзакция ранее была отменена"),
            3 => ["error"=>"-3","error_note"=>"Action not found"],
            5 => ["error"=>"-5","error_note"=>"error trans"],
            404 => ['error'=>'-404','error_note'=>'not found trans'],
            500 => ['error'=>'-500','error_note'=>'Unknown error'],
        );

        $click_trans_id = $request->post('click_trans_id');
        $service_id = $request->post('service_id');
        $secret_key = $request->post('secret_key');
        $merchant_trans_id = $request->post('merchant_trans_id');
        $action = $request->post('action');
        $merchant_prepare_id = $request->post('merchant_prepare_id');
        $amount = $request->post('amount');
        $sign_time = $request->post('sign_time');
        $sign_string = $request->post('sign_string');

        $sign_string_veryfied = md5($click_trans_id .
            $service_id .
            $secret_key .
            $merchant_trans_id .
            ($action == 1 ? $merchant_prepare_id : '').
            $amount .
            $action.$sign_time); // Формирование ХЭШ подписи

        if( $sign_string != $sign_string_veryfied ){
            return $messages[1];
        }

        /*Check Actions*/
        if(!in_array($action,array(0,1))){
            return $messages[3];
        }
        return $request->post();
    }

    public function complete(){

    }

    public function Messages(){
        $messages = array(
            0 => array("error"=>"0","error_note"=>"success"),
            1 => array("error"=>"-1","error_note"=>"SIGN CHECK FAILED!"),
            2 => array("error"=>"-2","error_note"=>"Incorrect parameter amount"),
            4 => array("error"=>"-4","error_note"=>"Транзакция ранее была подтверждена"),
            9 => array("error"=>"-9","error_note"=>"Транзакция ранее была отменена"),
            3 => ["error"=>"-3","error_note"=>"Action not found"],
            5 => ["error"=>"-5","error_note"=>"error trans"],
            404 => ['error'=>'-404','error_note'=>'not found trans'],
            500 => ['error'=>'-500','error_note'=>'Unknown error'],
        );

    }
}
