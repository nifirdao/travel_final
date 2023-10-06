<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php require "ConDb.php"; ?>
<?php 

  if(isset($_GET['province_id'])) {

    $id = $_GET['province_id'];

    $province = $conn->query("SELECT * FROM tbl_province WHERE province_id='$id'");
    $province->execute();

    $singleProvince = $province->fetch(PDO::FETCH_OBJ);


}

?>
 <!-- ***** Main Banner Area Start ***** -->
 <div class="about-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <div class="blur-bg"></div>
            <h4>EXPLORE OUR PROVINCE</h4>
            <div class="line-dec"></div>
            <h2>Welcome To <?php echo $singleProvince->province_name; ?></h2>
            <p>
            <?php echo $singleProvince->province_description; ?>
            </p>
            <div class="main-button">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Main Banner Area End ***** -->

<?php 

$province_id = isset($_GET['province_id']) ? $_GET['province_id'] : null;

// ตรวจสอบค่า province_id และแสดงข้อมูลตามจังหวัดที่เลือก
if ($province_id == 1) {
    // แสดงข้อมูลสำหรับจังหวัดที่มี province_id เป็น 1
    $sql = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE province_id = 1";
} elseif ($province_id == 2) {
    // แสดงข้อมูลสำหรับจังหวัดที่มี province_id เป็น 2
    $sql = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE province_id = 2";
} elseif ($province_id == 3) {
  // แสดงข้อมูลสำหรับจังหวัดที่มี province_id เป็น 2
  $sql = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE province_id = 3";
}
else {
    // กรณีที่ไม่ระบุ province_id หรือไม่มีข้อมูล
    echo "กรุณาเลือกจังหวัด";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="css/styles_about.css">
    <!-- ... ตกแต่งกล่องค้นหา ... -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/styles_about.css">
</head>

<main>
<section class="search-container">
    <form action="" method="post">
      <input type="text" name="search" placeholder="ค้นหาชื่อสถานที่">
      <button type="submit">ค้นหา</button>
    </form>
  </section>
  <section class="places-container">
    <?php
   
    // ดำเนินการต่อไปเฉพาะเมื่อมีค่า $sql ถูกกำหนด (เมื่อระบุ province_id ที่ถูกต้อง)
if (isset($sql)) {
  $result = mysqli_query($con, $sql);

  //เงื่อนไข ค้นหา
  if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $query = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE attrac_name LIKE '%$search%'";
    $result = mysqli_query($con, $query);
  }


  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // ดึงข้อมูลจากแต่ละแถวในตาราง tbl_attraction
        $attrac_name = $row['attrac_name'];
        $attrac_detail = $row['attrac_detail'];
        //$attrac_img = $row['attrac_img'];

        // แสดงข้อมูลในรูปแบบที่ต้องการ
        echo '<div class="place">';
        echo '<div class="place-img-box">';
        echo "<td align=center>"."<img src='http://localhost/travel/TestCode/backend/attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";
        echo '</div>';                                
        echo '<div class="place-info">';
        echo '<h3>' . $attrac_name . '</h3>';
        echo '<p>' . $attrac_detail . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // หากไม่มีข้อมูลจากคำสั่ง SQL
    echo 'ไม่พบข้อมูล';
}
}
    ?>
  </section>
</main>

<body>
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
