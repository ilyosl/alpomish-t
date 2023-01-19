<?php

echo "sadas";

$event2 = $_POST['event_log'];

if($event2 != "") {
    $event = json_decode($event2,true);
    $device_ip = $event['ipAddress'];
	$type = $event['AccessControllerEvent']['subEventType'];
	if($type == 9) {
$qr = $event['AccessControllerEvent']['cardNo'];
	if($qr == "1234567890")
	{
$curl = curl_init();
$url = "http://".$device_ip."/ISAPI/AccessControl/RemoteControl/door/1";
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
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
    <cmd>open</cmd>
</RemoteControlDoor>',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/octet-stream'
  ),
));

$response = curl_exec($curl);

curl_close($curl);


		}
	}
}

