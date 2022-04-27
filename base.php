<?php
$host = "localhost";
$dbname = "contact";
$userName = "nmk";
$psw = '123456';
$connect = mysqli_connect($host, $userName, $psw, $dbname);

if(!$connect){
die("failed to connect");
}