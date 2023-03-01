<?php

namespace App\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class SendSms
{
    public function AuthGatway(){
        $client = new Client();
        $options = [
            'multipart' => [
                [
                    'name' => 'email',
                    'contents' => 's.abduganiev@gmail.com'
                ],
                [
                    'name' => 'password',
                    'contents' => 'xQefwAWYAFy5hB3c9U9govnnNySyvEZZvjndwj1M'
                ]
            ]
        ];
        $request = new Request('POST', 'notify.eskiz.uz/api/auth/login');
        $res = $client->sendAsync($request, $options)->wait();
        $response = json_decode($res->getBody());
        return ['token'=>$response->data->token ?? ''];
    }
    /*
     * [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'auth' => [
                'alpamishice',
                'uvl7z{tz=?R)'
            ]
        ]
     * */
    public function sendSms($phone, $text){
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Basic YWxwYW1pc2hpY2U6dXZsN3p7dHo9P1Ip'
        ];
        $message_id = uniqid();
        $body = '{
          "messages": [
            {
              "recipient": "'.$phone.'",
              "message-id": "123",
              "sms": {
                "originator": "3700",
                "content": {
                  "text": "'.$text.'"
                }
              }
            }
          ]
        }';
        $request = new Request('POST', 'https://send.smsxabar.uz/broker-api/send',$headers, $body);

        //, $options
        $res = $client->sendAsync($request)->wait();

        return $res->getBody();
        /*$token = $this->AuthGatway();
        if($token['token']){
            $client = new Client();
            $headers = [
                'Authorization' => 'Bearer '.$token['token']
            ];
            $options = [
                'multipart' => [
                    [
                        'name' => 'mobile_phone',
                        'contents' => $phone
                    ],
                    [
                        'name' => 'message',
                        'contents' => $text
                    ],
                    [
                        'name' => 'from',
                        'contents' => '4546'
                    ]
                ]];
            $request = new Request('POST', 'notify.eskiz.uz/api/message/sms/send', $headers);
            $res = $client->sendAsync($request, $options)->wait();
            $response = json_decode($res->getBody());
            return $response;
        }*/
    }
}
