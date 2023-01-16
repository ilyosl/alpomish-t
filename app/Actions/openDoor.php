<?php

namespace App\Actions;

class openDoor
{
    public function actionDoor($isaction, $ipaddress){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://'.$ipaddress.'/ISAPI/AccessControl/RemoteControl/door/1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPAUTH =>CURLAUTH_DIGEST,
            CURLOPT_USERPWD => "admin:12345678a",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>'<RemoteControlDoor version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
                    <doorNo min="1" max="1"></doorNo>
                    <cmd>'.$isaction.'</cmd>
                </RemoteControlDoor>',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/octet-stream'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }



}
