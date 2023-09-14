<?php
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_member:
$query = "SELECT * FROM tbl_province ORDER BY province_id asc" or die("Error:" . mysqli_error());
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
?>
<div class="container">
  <div class="row">
      <form  name="addattraction" action="attrac_form_add_db.php" method="POST" enctype="multipart/form-data"  class="form-horizontal">
        <div class="form-group">
          <div class="col-sm-9">
            <p> ชื่อสถานที่ท่องเที่ยว </p>
            <input province="text"  name="attrac_name" class="form-control" required placeholder="ชื่อสถานที่ท่องเที่ยว" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-8">
            <p> จังหวัด </p>
            <select name="province_id" class="form-control" required>
              <option value="province_id">จังหวัด</option>
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
            <p> รายละเอียด </p>
             <textarea  name="attrac_detail" rows="5" cols="60"></textarea>
          </div>
        </div>
        <div class="form-group">
          
          <div class="col-sm-12">
            <p> ภาพสถานที่ท่องเที่ยว </p>
            <input type="file" name="attrac_img" id="attrac_img" class="form-control" />
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-success" name="btnadd"> บันทึก </button>
            
          </div>
        </div>
      </form>
    </div>
  </div> 