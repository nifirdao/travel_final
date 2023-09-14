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



<main>
  <section class="places-container">
    <?php
   while($row = mysqli_fetch_array($result)) {
      // ดึงข้อมูลจากแต่ละแถวในตาราง tbl_actraction
      $attrac_name = $row['attrac_name'];
      $attrac_detail = $row['attrac_detail'];
      //$attrac_img = $row['attrac_img'];  // นี่คือ URL หรือชื่อไฟล์รูปภาพ

      // แสดงข้อมูลในรูปแบบที่ต้องการ
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
    ?>
  </section>
</main>



<style>
  /* ... ส่วนที่เหมือนเดิม ... */

  .places-container {
    /* เพิ่ม CSS เพื่อกำหนดการจัดวางเรียงกันในแนวนอน */
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
    gap: 20px; /* กำหนดระยะห่างระหว่างกรอบ */
  }

  .place {
    /* ... ส่วนที่เหมือนเดิม ... */
    display: flex;
    flex-direction: column;
    align-items: center;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 10px;
    max-width: 300px; /* ปรับขนาดกรอบให้เหมาะสม */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* เพิ่มเงากรอบ */
  }
  
  .place h3 {
    /* เปลี่ยนสีข้อความใน p_name ตามที่ต้องการ */
    color: #22B3C1; /* สีฟ้าทะเล */
    /* หรือสามารถใช้รหัสสีหรือชื่อสีอื่น ๆ */
  }

  .place-img-box {
    /* ... ส่วนที่เหมือนเดิม ... */
    width: 200px;
    height: 200px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    border: 5px solid #ccc;
    margin-bottom: 10px;
  }

  .place-img-box img {
    /* ... ส่วนที่เหมือนเดิม ... */
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
  }

  .place-info {
    /* ... ส่วนที่เหมือนเดิม ... */
    text-align: center;
  }
</style>

</body>

</html>

<?php require "includes/footer.php"; ?>
