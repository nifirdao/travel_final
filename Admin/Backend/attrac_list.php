<?php
//1. เชื่อมต่อ database:
include('condb.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//2. query ข้อมูลจากตาราง 
$search = $_GET['search']; // รับค่าคำค้นหาจากฟอร์ม

$query = "SELECT * FROM tbl_attraction as p 
          INNER JOIN tbl_province as t ON p.province_id=t.province_id 
          WHERE p.attrac_name LIKE '%$search%'
          ORDER BY p.attrac_id DESC";
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:



echo  ' <table class="table table-hover">';
  //หัวข้อตาราง 
  //echo "<td>" .$row["attrac_detail"] .  "</td> ";
  //<td width=25%>detail</td>
    echo "<tr>
      <td width='5%'>id</td>
      <td width=15%>province</td>
      <td width=30%>name</td>
      
      <td width=30%>image</td>

      <td width=5%>edit</td>
      <td width=5%>delete</td>
    </tr>";
  while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
    echo "<td>" .$row["attrac_id"] .  "</td> ";
    echo "<td>" .$row["province_name"] .  "</td> ";
    echo "<td>" .$row["attrac_name"] .  "</td> ";
    //echo "<td>" .$row["attrac_detail"] .  "</td> ";
    echo "<td align=center>"."<img src='attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";

    //แก้ไขข้อมูล
    echo "<td><a href='attrac.php?act=edit&ID=$row[0]' class='btn btn-warning btn-xs'>edit</a></td> ";
    
    //ลบข้อมูล
    echo "<td><a href='attrac_form_del_db.php?ID=$row[0]' onclick=\"return confirm('คุณต้องการลบสถานที่ท่องเที่ยวนี้หรือไม่? !!!')\" class='btn btn-danger btn-xs'>del</a></td> ";
  echo "</tr>";
  }
echo "</table>";
//5. close connection
mysqli_close($con);
?> 
