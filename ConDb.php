<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "pro";

$con = mysqli_connect($host, $username, $password, $dbname);
if (!$con) {
  die("เชื่อมต่อกับฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}
mysqli_query($con, "SET NAMES 'utf8'");
date_default_timezone_set('Asia/Bangkok');
?>
