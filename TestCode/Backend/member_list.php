<?php
include('h.php');
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง tb_admin:
$query = "SELECT * FROM users ORDER BY id ASC" or die("Error:" . mysqli_error());
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:

?>

<script>
  $(document).ready(function() {
    $('#example1').DataTable({
      "aaSorting": [
        [0, 'ASC']
      ],
      //"lengthMenu":[[20,50, 100, -1], [20,50, 100,"All"]]
    });
  });
</script>

<table border="2" class="display table table-bordered" id="example1" align="center">
  <thead>
    <tr class="info">
      <th width="12%">Users id</th>
      <th width="15%">User name</th>
      <th>Email</th>
      <th width="20%">Created at</th>
      <th width="5%">Gender</th>
      
    </tr>
  </thead>
  <?php do { ?>

    <tr>
      <td><?php echo $row_am['id']; ?></td>
      <td><?php echo $row_am['username']; ?></td>
      <td><?php echo $row_am['email']; ?></td>
      <td><?php echo $row_am['created_at']; ?></td>
      <td><?php echo $row_am['gender']; ?></td>

    </tr>

  <?php } while ($row_am =  mysqli_fetch_assoc($result)); ?>

</table>
