<?php
session_start();
require "../app/core/init.php";

$url = $_GET['url'] ?? 'home';
$url = strtolower($url);
$url = explode("/",$url);
$pagename = trim($url[0]);
$filename = "../app/pages/" .$pagename .".php";
$PAGE =getpagevars();


if(file_exists($filename)){
    require_once $filename;
}
else
{
    require_once "../app/pages/404.php";
}

?>