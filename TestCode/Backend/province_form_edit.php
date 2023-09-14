<?php
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
$province_id = $_REQUEST["ID"];
//2. query ข้อมูลจากตาราง:
$sql = "SELECT * FROM tbl_province WHERE province_id='$province_id' ";
$result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
$row = mysqli_fetch_array($result);
extract($row);
?>
<?php include('h.php');?>
<div class="container">
  <p> </p>
    <div class="row">
      <div class="col-md-12">
        <form  name="admin" action="province_form_edit_db.php" method="POST" id="admin" class="form-horizontal">
          <input type="hidden" name="province_id" value="<?php echo $province_id; ?>" />
          <div class="form-group">
            <div class="col-sm-6" align="left">
              <input  name="province_name" type="text" required class="form-control" id="province_name" value="<?=$province_name;?>" placeholder="ชื่อจังหวัด" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="2"  />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6" align="right">
              <button type="submit" class="btn btn-success btn-sm" id="btn"> บันทึก </button>      
            </div> 
          </div>
        </form>
      </div>
    </div>
</div>