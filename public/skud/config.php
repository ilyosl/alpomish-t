<?php
error_reporting(1);
require_once 'vendor/autoload.php';
$db = new MysqliDb ('localhost', 'sanjar', 'CfyF,le', 'skud');
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new Twig\Environment($loader, array());
/*
if(str_contains($_SERVER['SCRIPT_NAME'],"login.php")) {

} else {
    $token = $_COOKIE['token'];
    if(!$token) {
        header("Location: login.php");
    }
}*/

