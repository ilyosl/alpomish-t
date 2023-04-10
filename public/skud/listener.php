<?php


$event2 = $_POST['event_log'];

if ($event2 != "") {
    require_once 'vendor/autoload.php';
    $db = new MysqliDb ('localhost', 'sanjar', 'CfyF,le', 'skud');
    $event = json_decode($event2, true);
    $device_ip = $event['ipAddress'];
    $type = $event['AccessControllerEvent']['subEventType'];
    $worker_id = $event['AccessControllerEvent']['employeeNoString'];
    if ($type == 75) {

        $data = array(
            "date" => $db->NOW(),
            "ip" => $device_ip,
            "logdata" => $event2

        );
        $db->insert("eventlog", $data);
        // echo $event2;

        // Camera kirish yoki chiqishga turganini tekshiramiz
        $db->where("ip",$device_ip);
        $device_type = $db->getValue("device","type");
        if($device_type == "enter") {
            $db->where("worker_id",$worker_id);
            $db->where("status",0);
            $db->getOne("report");
            $daten = date("Y-m-d");
            if($db->count>0) {

            } else {
                $data = array(
                    "worker_id"=>$worker_id,
                    "enter_date"=>$db->NOW(),
                    "status"=>0,
                    "date"=>$daten
                );
                $db->insert("report",$data);
            }


        } elseif($device_type == "exit") {
            $db->where("worker_id",$worker_id);
            $db->where("status",0);
            $res = $db->getOne("report");
            if($db->count>0) {
                $dateenter = $res['enter_date'];
                $dateexit = date("Y-m-d H:i:s");
                $date1 = new DateTime($dateenter);
                $date2 = new DateTime($dateexit);
                $diff_mins = round(abs($date1->getTimestamp() - $date2->getTimestamp()) / 60);
                $hours = round($diff_mins / 60);
                $data = array(

                    "exit_date"=>$db->NOW(),
                    "status"=>1,
                    "time"=>$diff_mins,
                    "hours"=>$hours
                );
                $db->where("id",$res['id']);

                $db->update("report",$data);
            } else {

            }

        }




        /*
       // $qr = $event['AccessControllerEvent']['cardNo'];
        //if ($qr == "1234567890") {
        sleep(5);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://192.168.0.11/ISAPI/AccessControl/RemoteControl/door/1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPAUTH => CURLAUTH_DIGEST,
                CURLOPT_USERPWD => "admin:12345678a",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => '<RemoteControlDoor version="2.0" xmlns="http://www.isapi.org/ver20/XMLSchema">
    <doorNo min="1" max="1"></doorNo>
    <cmd>open</cmd>
</RemoteControlDoor>',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/octet-stream'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            echo $response;

*/
    }
    //}


}

