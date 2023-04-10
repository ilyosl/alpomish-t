<?php
require_once "config.php";
if($_POST['login'] AND $_POST['password']) {
    // login va parolni olib tekshiramiz
echo "dsadsa";
$login = $_POST['login'];
$passhash = md5($_POST['password']);

$db->where("login",$login);
$db->where("password",$passhash);
$db->getOne("users");
if($db->count>0) {
    echo "OK";
    // generasiya cookie token
    //
} else {
    echo "Oshibka";
}



}
echo $twig->render("login.html");
