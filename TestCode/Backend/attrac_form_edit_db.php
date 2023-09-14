<meta charset="UTF-8">
<?php
//1. เชื่อมต่อ database: 
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
  //Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
    date_default_timezone_set('Asia/Bangkok');
	//สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลด
	$date1 = date("Ymd_His");
	//สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
	$numrand = (mt_rand());
	
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
	$attrac_id = $_POST["attrac_id"];
	$attrac_name = $_POST["attrac_name"];
	$province_id = $_POST["province_id"];
	$attrac_detail = $_POST["attrac_detail"];
	$attrac_img = (isset($_POST['attrac_img']) ? $_POST['attrac_img'] : '');
	$img2 = $_POST['img2'];
	$upload=$_FILES['attrac_img']['name'];
	if($upload !='') { 
		
	//โฟลเดอร์ที่เก็บไฟล์
	$path="attrac_img/";
	//ตัวขื่อกับนามสกุลภาพออกจากกัน
	$type = strrchr($_FILES['attrac_img']['name'],".");
	//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
	$newname =$numrand.$date1.$type;
 
	$path_copy=$path.$newname;
	$path_link="attrac_img/".$newname;
	//คัดลอกไฟล์ไปยังโฟลเดอร์
	move_uploaded_file($_FILES['attrac_img']['tmp_name'],$path_copy);  
		
	}else {
		$newname = $img2;
	
	}

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database 
	
	$sql = "UPDATE tbl_attraction SET  
			attrac_name='$attrac_name',
			province_id='$province_id', 
			attrac_detail='$attrac_detail',
			attrac_img='$newname'
			WHERE attrac_id='$attrac_id' ";

$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());

mysqli_close($con); //ปิดการเชื่อมต่อ database 

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม
	
	if($result){
	echo "<script type='text/javascript'>";
	echo "alert('แก้ไขข้อมูลเรียบร้อย');";
	echo "window.location = 'attrac.php'; ";
	echo "</script>";
	}
	else{
	echo "<script type='text/javascript'>";
	echo "alert('Error back to Update again');";
	echo "</script>";
}
?>