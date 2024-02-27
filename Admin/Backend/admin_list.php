<?php
include('h.php');
error_reporting(error_reporting() & ~E_NOTICE);
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_admin:
$query = "SELECT * FROM tbl_admin ORDER BY a_id ASC";
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
$row_am = mysqli_fetch_assoc($result);
?>



<table border="2" class="display table table-bordered" id="example1" align="center">
  <thead>
    <tr class="info">
      <th width="5%">id</th>
      <th>a_user</th>
      <th>a_name</th>
      
    </tr>
  </thead>
  <?php do { ?>

    <tr>
      <td><?php echo $row_am['a_id']; ?></td>
      <td><?php echo $row_am['a_user']; ?></td>
      <td><?php echo $row_am['a_name']; ?></td>
     
    </tr>

  <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>