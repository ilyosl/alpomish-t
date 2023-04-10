<?php
require_once "config.php";
function generate_array_days($month, $year) {
    // Check if the month and year are valid integers
    if (!is_int($month) || !is_int($year) || $month < 1 || $month > 12 || $year < 1) {
        return "fdd"; // Return false if not valid
    }
    // Get the number of days in the month using the cal_days_in_month function
    $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    // Create an empty array to store the days
    $days = array();
    // Loop from 1 to the number of days and add each day to the array
    for ($i = 1; $i <= $num_days; $i++) {
        $days[] = $i;
    }
    // Return the array of days
    return $days;
}
function generate_array_days2($month, $year) {
    // Check if the month and year are valid integers
    if (!is_int($month) || !is_int($year) || $month < 1 || $month > 12 || $year < 1) {
        return "fdd"; // Return false if not valid
    }
    // Get the number of days in the month using the cal_days_in_month function
    $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    // Create an empty array to store the days
    $days = array();
    // Loop from 1 to the number of days and add each day to the array
    for ($i = 1; $i <= $num_days; $i++) {
        if($month < 10) {
            if($i < 10) {
                $days[] = $year."-0".$month."-0".$i;
            } else {
                $days[] = $year."-0".$month."-".$i;
            }

        } else {
            if($i < 10) {
                $days[] = $year."-".$month."-0".$i;
            } else {
                $days[] = $year."-".$month."-".$i;
            }
        }

    }
    // Return the array of days
    return $days;
}

if($_GET['year']) {
    $yearg = (int) $_GET['year'];
} else {
    $yearg = (int) date("Y");
}
if($_GET['month']) {
    $monthg = (int) $_GET['month'];
}
else {
    $monthg = (int) date("m");
}

$days = generate_array_days($monthg,$yearg);
$daysdate = generate_array_days2($monthg,$yearg);
$first = reset($daysdate);
$last = end($daysdate);
$worker_id = $_GET['worker_id'];
$sql = "SELECT * FROM report WHERE (report.date >= '$first' AND report.date <= '$last') AND worker_id = '$worker_id' ORDER BY id DESC";
$report = $db->rawQuery($sql);

$sql2 = "SELECT DISTINCT YEAR(date) as dates, DATE_FORMAT(date,'%m') as months FROM report WHERE worker_id = '$worker_id'";
$month_hour = $db->rawQuery($sql2);
$link = "<select onchange=\"location=value\">";
//$link = $link. "<option value=\"\" >Выбрать из месяц списка</option>";
$workername = $_GET['workername'];
foreach($month_hour as $mon)
{
    $month_all = $mon['dates'];
    $mm = $mon['months'];
    $month_all2 = date("m",$mon['date']);
    switch ($mm) {
        case '1': $monthname = "Январь"; break;
        case '2': $monthname = "Февраль"; break;
        case '3': $monthname = "Март"; break;
        case '4': $monthname = "Апрель";break;
        case '5': $monthname = "Май";break;
        case '6': $monthname = "Июнь";break;
        case '7': $monthname = "Июль";break;
        case '8': $monthname = "Август";break;
        case '9': $monthname = "Сентябрь";break;
        case '10':$monthname = "Октябрь";break;
        case '11':$monthname = "Ноябрь";break;
        case '12':$monthname = "Декабрь";break;
        default:$monthname = "nope";break;
    }
    if($_GET['year'] AND $_GET['month']) {
        // $link = $link . "<option value=\"?year=$month_all&month=$mm&date=$month_all-$mm-01\">$monthname - $month_all</option>";
        if ($monthg == $mm and $yearg == $month_all) {
            $link = $link . "<option value=\"?worker_id=$worker_id&workername=$workername&year=$month_all&month=$mm&date=$month_all-$mm-01\" selected=\"selected\">$monthname - $month_all</option>";
        } else {

            $link = $link . "<option value=\"?worker_id=$worker_id&workername=$workername&year=$month_all&month=$mm&date=$month_all-$mm-01\">$monthname - $month_all</option>";
        }

    } else {
        if ($monthnow == $mm and $yearnow == $month_all) {
            $link = $link . "<option value=\"?worker_id=$worker_id&workername=$workername&year=$month_all&month=$mm&date=$month_all-$mm-01\" selected=\"selected\">$monthname - $month_all</option>";
        } else {

            $link = $link . "<option value=\"?worker_id=$worker_id&workername=$workername&year=$month_all&month=$mm&date=$month_all-$mm-01\">$monthname - $month_all</option>";
        }
    }


}
$link = $link . '</select>';



$data = [
    "worker_id"=>$worker_id,
    "worker_name"=>$workername,
    "days"=>$days,
    "year"=>$yearg,
    "month"=>$monthg,
    "daysdate"=>$daysdate,
    "report"=>$report,
    "selectmonth"=>$link
];
//echo "<pre>";
//print_r($data);

echo $twig->render("reportworker.html",$data);