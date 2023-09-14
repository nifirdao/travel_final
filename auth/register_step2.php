<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 

if(isset($_SESSION["username"])) {
  header("location: ".APPURL."");
}

if (isset($_POST['submit'])) {
  // ตรวจสอบว่ามีการส่งค่า POST มาจากฟอร์ม

  // ตรวจสอบค่า POST ว่าถูกต้องหรือไม่
  $valid = true;

  // ตรวจสอบคะแนนเที่ยวธรรมชาติ
  if (!isset($_POST['nature']) || empty($_POST['nature']) || !is_numeric($_POST['nature']) || $_POST['nature'] < 0 || $_POST['nature'] > 5) {
    $valid = false;
}


  // ตรวจสอบคะแนนเรียนรู้วัฒนธรรม
  if (!isset($_POST['culture']) || !is_numeric($_POST['culture']) || $_POST['culture'] < 0 || $_POST['culture'] > 5) {
    $valid = false;
  }

  // ตรวจสอบคะแนนประวัติศาสตร์
  if (!isset($_POST['history']) || !is_numeric($_POST['history']) || $_POST['history'] < 0 || $_POST['history'] > 5) {
    $valid = false;
  }

  // ตรวจสอบคะแนนกิจกรรมด้านบันเทิง
  if (!isset($_POST['entertainment']) || !is_numeric($_POST['entertainment']) || $_POST['entertainment'] < 0 || $_POST['entertainment'] > 5) {
    $valid = false;
  }

  if (!$valid) {
    echo "<script>alert('Invalid input. Please enter valid scores between 0 and 5.');</script>";
  } else {
    // หลังจากตรวจสอบและยืนยันความถูกต้องของข้อมูล

    // ดึงคะแนนที่ได้จาก POST
    $nature_score = $_POST['nature'];
    $culture_score = $_POST['culture'];
    $history_score = $_POST['history'];
    $entertainment_score = $_POST['entertainment'];

    // บันทึกคะแนนลงในตาราง user_category_scores
    $insertScores = $conn->prepare("INSERT INTO user_category_scores (User_ID, Cat_ID, Cat_Score)
    VALUES (:user_id, :cat_id, :cat_score)");

    // คำนวณคะแนนสำหรับแต่ละหมวดหมู่
    $categories = [
      'nature' => 'C1',
      'culture' => 'C2',
      'history' => 'C3',
      'entertainment' => 'C4',
    ];

    // ใส่คะแนนลงในตาราง
    // Generate a unique ID for each cat_score (you can use a function like uniqid())
$cat_score_id = uniqid();

foreach ($categories as $category_key => $cat_id) {
  $cat_score = $_POST[$category_key];

  $insertScores->execute([
    ":user_id" => $user_id,
    ":cat_id" => $cat_id,
    ":cat_score_id" => $cat_score_id,
    ":cat_score" => $cat_score,
  ]);
}



    // หลังจากบันทึกข้อมูลคะแนนเสร็จสิ้น คุณสามารถเรียกใช้ header() เพื่อเปลี่ยนเส้นทางไปยังหน้าถัดไป

    header("location: login.php");
  }
}
?>


<div class="reservation-form">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <form id="reservation-form" name="gs" method="POST" action="register_step2.php">
          <div class="row">
            <div class="col-lg-12">
              <h4>Register - Step 2</h4>
            </div>
            <div class="col-md-12">
              <h5>คะแนนหมวดหมู่สถานที่</h5>
              <div class="form-group">
                <label for="nature">เที่ยวธรรมชาติ:</label>
                <input type="number" name="nature" class="form-control" min="0" max="5" required>
              </div>
              <div class="form-group">
                <label for="culture">เรียนรู้วัฒนธรรม:</label>
                <input type="number" name="culture" class="form-control" min="0" max="5" required>
              </div>
              <div class="form-group">
                <label for="history">ประวัติศาสตร์:</label>
                <input type="number" name="history" class="form-control" min="0" max="5" required>
              </div>
              <div class="form-group">
                <label for="entertainment">กิจกรรมด้านบันเทิง:</label>
                <input type="number" name="entertainment" class="form-control" min="0" max="5" required>
              </div>
            </div>

             <!-- ปุ่มย้อนกลับอยู่ฝั่งซ้าย -->
                  <div class="col-lg-6">
                  <fieldset>
                    <button class="secondary-button" onclick="goBack()">ย้อนกลับ</button>
                  </fieldset>
                </div>

                <script>
                function goBack() {
                  //window.history.back();
                  window.location.href = 'register.php';
                }
                </script>
                    
                <div class="col-lg-6">
                  <!-- ปุ่มไปหน้าถัดไป -->
                  <fieldset>
                    <button type="button" class="main-button" onclick="goToNextStep()">ถัดไป</button>
                  </fieldset>
                </div>

                <!-- ...โค้ดที่เหลือ... -->

                <script>
                function goToNextStep() {
                  // ไปยังหน้า register_step2.php
                  window.location.href = 'register_step3.php';
                }
                </script>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require "../includes/footer.php"; ?>
