<?php 

$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "blog";

$db = new mysqli($host, $user, $password, $dbname);

if ($db->connect_errno)
{
    die($db->connect_error);
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();