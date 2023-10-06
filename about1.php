<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php require "ConDb.php"; ?>



<?php 
$attrac_id = $_GET["id"];

$query = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE attrac_id = attrac_id";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- ... ตกแต่งกล่องค้นหา ... -->
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/styles_about.css">
</head>

<main>
   <!-- ... สร้างฟอร์มกล่องค้นหา ... -->
 <section class="search-container">
    <form action="" method="post">
      <input type="text" name="search" placeholder="ค้นหาชื่อสถานที่">
      <button type="submit">ค้นหา</button>
    </form>
  </section>
  <section class="places-container">
    <?php
    //เงื่อนไข ค้นหา
    if (isset($_POST['search'])) {
      $search = $_POST['search'];
      $query = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE attrac_name LIKE '%$search%'";
      $result = mysqli_query($con, $query);
    }

    
    if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_array($result)) {
      // ดึงข้อมูลจากแต่ละแถวในตาราง tbl_actraction
      $attrac_name = $row['attrac_name'];
      $attrac_detail = $row['attrac_detail'];
      //$attrac_img = $row['attrac_img'];  // นี่คือ URL หรือชื่อไฟล์รูปภาพ

      // แสดงข้อมูลในรูปแบบสถานที่ท่องเที่ยวที่ต้องการ
      echo '<div class="place">';
      echo '<div class="place-img-box">';
      echo "<td align=center>"."<img src='http://localhost/travel/TestCode/backend/attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";
     // echo "<td align=center>"."<img src='../Backend/attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";

      //echo '<img src="' . $attrac_img . '" alt="' . $attrac_name . '">';
      
  
     // echo "<td align=center>"."<img src='attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";
      
      echo '</div>';
      echo '<div class="place-info">';
      echo '<h3>' . $attrac_name . '</h3>';
      echo '<p>' . $attrac_detail . '</p>';
      echo '</div>';
      echo '</div>';
    }
  } else {
      // ไม่พบข้อมูลในการค้นหา
      echo "<script>alert('ไม่พบข้อมูล'); window.location.href='about1.php';</script>";
      exit();
  }
    ?>
  </section>
</main>
</html>

<?php require "includes/footer.php"; ?>
