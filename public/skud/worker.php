<?php
require_once "config.php";
$mod = $_GET['mod'];

// login page

// main page

// sotrudniki page CRUD

// list

function send_terminal($urlpath,$jsondata,$method) {
    global $db;
    $devices = $db->get("device");
    $statuscodeall = 1;
    foreach ($devices as $device) {
        $ip = $device['ip'];
        $curl = curl_init();
        $url = "http://".$ip.$urlpath;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTPAUTH =>CURLAUTH_DIGEST,
            CURLOPT_USERPWD => "admin:12345678a",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS =>$jsondata,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response,true);
        $statuscode1 = $status['statusCode'];
        if($statuscode1 != 1) {
            $statuscodeall = $statuscodeall + 1;
        }
    }
    return $statuscodeall;


}


function main() {
    global $db, $twig, $mod;
    $error = $_GET['error'];
    $db->where("status",1);
    $result = $db->get("worker");
    echo $twig->render("worker.html",array("mod"=>$mod,"workers"=>$result,"error"=>$error));
}
// add
function add() {
    global  $db, $twig, $mod;
    echo $twig->render("worker.html",array("mod"=>$mod));
}

function addsave() {
    global  $db, $twig, $mod;
    $fio = $_POST['fio'];
    //echo $fio;

    if($fio) {
        $id = $db->insert("worker",array("name"=>$fio));
         if($id)
        {
            // devicelarga person yaratamiz
            $jsondata = '{"UserInfo":{ 
            "employeeNo": "'.$id.'",
            "name": "'.$fio.'",
            "userType": "normal",
            "Valid": {
                        "enable": true,
			            "beginTime": "2022-02-01T01:00:00",
			            "endTime": "2025-02-01T01:00:00",
			            "timeType": "local"
			},
            "doorRight": "1",
            "RightPlan": [
                    {
                        "doorNo": 1,
                        "planTemplateNo": "1"
                    }
            ]      
	        }
            }';
           $status = send_terminal("/ISAPI/AccessControl/UserInfo/Record?format=json",$jsondata,"POST");
           if($status == 1) {
               header("Location: worker.php");
               die();
           }
           else {
              header("Location: worker.php?error=1");
               die();
           }

        }

    }
    //
}

// add
function addphoto() {
    global  $db, $twig, $mod;
    $worker_id = $_GET['worker_id'];
    echo $twig->render("worker.html",array("mod"=>$mod,"worker_id"=>$worker_id));
}
function image_resize($source,$width,$height) {
    $new_width =600;
    $new_height =800;
    $thumbImg=imagecreatetruecolor($new_width,$new_height);
    imagecopyresampled($thumbImg,$source,0,0,0,0,$new_width,$new_height,$width,$height);
    return $thumbImg;
}

function addphotosave() {
    global  $db, $twig, $mod;
    $worker_id = $_POST['worker_id'];
    if (isset($_FILES['photo'])) {
        // Get the name and temporary location of the file
        //$file_name = $_FILES['photo']['name'];
        $file_name = rand(100000000,999999999).".jpg";
        $file_tmp = $_FILES['photo']['tmp_name'];
        // Define the destination folder where you want to save the file
        $upload_dir = "upload/";
        // Move the file from the temporary location to the destination folder
        if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
            // Display a success message
            //resize image
// Image resize and give new name
            $image = "upload/".$file_name;
            $imgProperties = getimagesize($image);
            $pathToThumbs = "upload/t/".$file_name;
            $img_type = $imgProperties[2];
            if( $img_type == IMAGETYPE_JPEG ) {
                $source = imagecreatefromjpeg($image);
                $resizeImg = image_resize($source,$imgProperties[0],$imgProperties[1]);
                imagejpeg($resizeImg,$pathToThumbs);
            }

            // upload photo to terminal if ok write to db
            // before we delete photo by workerid if exits photo

            $jsondata = '{
                "FPID":[
                    {
                        "value":"'.$worker_id.'"
                    }
                ]
            }';
            send_terminal("/ISAPI/Intelligent/FDLib/FDSearch/Delete?format=json&FDID=1&faceLibType=blackFD",$jsondata,"PUT");
            $db->where("id",$worker_id);
            $worker_name = $db->getValue("worker","name");
            // upload
            $imgurl = "http://192.168.0.30/skud/upload/t/".$file_name;
            $jsondata = '{
                "faceURL":"'.$imgurl.'",
                "faceLibType":"blackFD",
                "FDID":"1",
                "FPID":"'.$worker_id.'",
                "name":"'.$worker_name.'",
                "gender":"male",
                "bornTime":"1985-04-04",
                "city":"1123"
            }';
            $status = send_terminal("/ISAPI/Intelligent/FDLib/FaceDataRecord?format=json",$jsondata,"POST");
            if($status == 1) {
//                echo "File uploaded successfully!";
//
//                // delete old foto
                $db->where("id",$worker_id);
                $img = $db->getValue("worker","img");
                unlink("upload/".$img);
                unlink("upload/t/".$img);
                // update data new foto
                $db->where("id",$worker_id);
                $db->update("worker",array("img"=>$file_name));
                header("Location: worker.php");
                die();
            }
            else {
                header("Location: worker.php?error=1");
                die();
            }
        } else {
            // Display an error message
            echo "File upload failed!";
        }
    }





}
// update
function edit() {
    global  $db, $twig, $mod;
    $worker_id=$_GET['worker_id'];
    $db->where("id",$worker_id);
    $result = $db->getOne("worker");
    echo $twig->render("worker.html",array("mod"=>$mod,"result"=>$result));
}
function editsave()
{
    global $db, $twig, $mod;
    $fio = $_POST['fio'];
    $worker_id=$_POST['worker_id'];
    //echo $fio;

    if ($fio) {
        $db->where("id",$worker_id);
        $db->update("worker", array("name" => $fio));
        header("Location: worker.php");
        die();

    }
}
// delete
function delete() {
    global  $db, $twig, $mod;
    $worker_id = $_GET['worker_id'];
    $db->where("id",$worker_id);
    $db->update("worker",array("status"=>0));
    $jsondata = '{
    "UserInfoDetail": {
        "mode":"byEmployeeNo",
        "EmployeeNoList":[{
            "employeeNo":"'.$worker_id.'"
        }]
    }
}';
    send_terminal("/ISAPI/AccessControl/UserInfoDetail/Delete?format=json",$jsondata,"PUT");

    header("Location: worker.php");
    die();
}

// report


switch ($mod) {
    case "add":
        add();
        break;
    case "addphoto":
        addphoto();
        break;
    case "addphotosave":
        addphotosave();
        break;
    case "addsave":
        addsave();
        break;
    case "edit":
        edit();
        break;
    case "editsave":
        editsave();
        break;
    case "delete":
        delete();
        break;
    default:
        main();
}
