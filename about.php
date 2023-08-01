
<?php
include('header.php');

include('ConDb.php');

// คำสั่ง SQL ในการดึงข้อมูลที่ต้องการจากตาราง tbl_product
$sql = "SELECT p_name, p_detail, p_img FROM tbl_product WHERE type_id IN (1, 2, 3)";
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">



<main>
  <section class="places-container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
      // ดึงข้อมูลจากแต่ละแถวในตาราง tbl_product
      $p_name = $row['p_name'];
      $p_detail = $row['p_detail'];
      $p_img = $row['p_img'];

      // แสดงข้อมูลในรูปแบบที่ต้องการ
      echo '<div class="place">';
      echo '<div class="place-img-box">';
      echo '<img src="data:image/jpeg;base64,' . base64_encode($p_img) . '" alt="' . $p_name . '">';
      echo '</div>';
      echo '<div class="place-info">';
      echo '<h3>' . $p_name . '</h3>';
      echo '<p>' . $p_detail . '</p>';
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
    /* เปลี่ยนสีข้อความใน p_name ตามที่คุณต้องการ */
    color: #22B3C1; /* สีฟ้าทะเล */
    /* หรือสามารถใช้รหัสสีหรือชื่อสีอื่น ๆ ได้เช่น #00ff00 (สีเขียว) หรือ blue (สีน้ำเงิน) */
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

<?php include('footer.php');