<?php
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$attrac_id = $_GET["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT p.*,t.province_name
FROM tbl_attraction as p 
INNER JOIN tbl_province as t ON p.province_id = t.province_id
WHERE p.attrac_id = '$attrac_id'
ORDER BY p.province_id asc";
$result2 = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result2);
extract($row);

//2. query ข้อมูลจากตาราง 
$query = "SELECT * FROM tbl_province ORDER BY province_id asc" or die("Error:" . mysqli_error());
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
?>
<div class="container">
  <div class="row">
      <form  name="addattrac" action="attrac_form_edit_db.php" method="POST" enctype="multipart/form-data"  class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-9">
            <p> สถานที่ท่องเที่ยว</p>
            <input type="text"  name="attrac_name" class="form-control" required placeholder="ชื่อสินค้า" / value="<?php echo $attrac_name; ?>">
          </div>
        </div>
         <div class="form-group">
          <div class="col-sm-6">
            <p> หมวดหมู่ </p>
            <select name="province_id" class="form-control" required>
              <option value="<?php echo $row["province_id"];?>">
                <?php echo $row["province_name"]; ?>
              </option>
              <option value="province_id">หมวดหมู่</option>
              <?php foreach($result as $results){?>
              <option value="<?php echo $results["province_id"];?>">
                <?php echo $results["province_name"]; ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <p> รายละเอียดสถานที่ </p>
             <textarea  name="attrac_detail" rows="5" cols="60"><?php echo $attrac_detail; ?>
             </textarea>
          </div>
        </div>
            <div class="form-group">
          <div class="col-sm-12">
            <p> ภาพสถานที่ </p>
            <img src="attrac_img/<?php echo $row['attrac_img'];?>" width="100px">
            <br>
            <br>
            <input type="file" name="attrac_img" id="attrac_img" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
             <input type="hidden" name="attrac_id" value="<?php echo $attrac_id; ?>" />
             <input type="hidden" name="img2" value="<?php echo $attrac_img; ?>" />
            <button type="submit" class="btn btn-success" name="btnadd"> บันทึก </button>
            
          </div>
        </div>
      </form>
    </div>
  </div> 