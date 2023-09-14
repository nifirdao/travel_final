<?php
$host = "localhost"; // ชื่อโฮสต์หรือที่อยู่ IP ของฐานข้อมูล MySQL
$username = "root";
$password = "";
$dbname = "travel"; // ชื่อฐานข้อมูลที่ต้องการเชื่อมต่อ

$con = mysqli_connect($host, $username, $password, $dbname);
if (!$con) {
  die("เชื่อมต่อกับฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}
mysqli_query($con, "SET NAMES 'utf8'");
date_default_timezone_set('Asia/Bangkok');
?>
