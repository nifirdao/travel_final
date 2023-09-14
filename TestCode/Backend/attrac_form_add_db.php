<meta charset="UTF-8">
<?php
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');
	//สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลด
	$date1 = date("Ymd_His");
	//สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
	$numrand = (mt_rand());
	//รับค่าไฟล์จากฟอร์ม
$attrac_name = $_POST['attrac_name'];
$province_id = $_POST['province_id'];
$attrac_detail = $_POST['attrac_detail'];
$attrac_img =(isset($_POST['attrac_img']) ? $_POST['attrac_img'] :'');
//img
	$upload=$_FILES['attrac_img'];
	if($upload <> '') {

	//โฟลเดอร์ที่เก็บไฟล์
	$path="attrac_img/";
	//ตัวขื่อกับนามสกุลภาพออกจากกัน
	$type = strrchr($_FILES['attrac_img']['name'],".");
	//ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
	$newname ='attrac_img'.$numrand.$date1.$type;
	$path_copy=$path.$newname;
	$path_link="attrac_img/".$newname;
	//คัดลอกไฟล์ไปยังโฟลเดอร์
	move_uploaded_file($_FILES['attrac_img']['tmp_name'],$path_copy);
	}
	// เพิ่มไฟล์เข้าไปในตาราง uploadfile
	
		$sql = "INSERT INTO tbl_attraction
		(
		attrac_name,
		province_id,
		attrac_detail,
		attrac_img
		)
		VALUES
		(
		'$attrac_name',
		'$province_id',
		'$attrac_detail',
		'$newname')";
		
		$result = mysqli_query($con, $sql);// or die ("Error in query: $sql " . mysqli_error());
	
	mysqli_close($con);
	// javascript แสดงการ upload file
	
	
	if($result){
echo "<script type='text/javascript'>";
echo "alert('เพิ่มข้อมูลเรียบร้อย');";
echo "window.location = 'attrac.php'; ";
echo "</script>";
}
else{
echo "<script type='text/javascript'>";
echo "alert('Error back to upload again');";
echo "window.location = 'attrac.php'; ";
echo "</script>";
}
?> 