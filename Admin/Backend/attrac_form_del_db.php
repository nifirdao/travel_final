<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//สร้างตัวแปรสำหรับรับค่า member_id จากไฟล์แสดงข้อมูล
$attrac_id = $_REQUEST["ID"];

//ลบข้อมูลออกจาก database ตาม member_id ที่ส่งมา 

$sql = "DELETE FROM tbl_attraction WHERE attrac_id='$attrac_id' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
  
  if($result){
  echo "<script type='text/javascript'>";
  echo "alert('ลบข้อมูลเสร็จสิ้น');";
  echo "window.location = 'attrac.php'; ";
  echo "</script>";
  }
  else{
  echo "<script type='text/javascript'>";
  echo "alert('เกิดข้อผิดพลาดกรุณาทำการลบอีกครั้ง!');";
  echo "</script>";
}
?>

