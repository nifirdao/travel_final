<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php require "ConDb.php"; ?>
<?php 
// ตรวจสอบว่าผู้ใช้กดปุ่ม "Search Results"
if (isset($_POST['submit'])) {
  // ตรวจสอบว่าผู้ใช้ล็อกอินแล้วและรับค่า user_id จากการล็อกอิน
  session_start();
  if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];

      // รับค่าที่ผู้ใช้กรอกในฟอร์ม
      $category_order_1 = $_POST['category_order_1'];
      $category_order_2 = $_POST['category_order_2'];
      $category_order_3 = $_POST['category_order_3'];
      $category_order_4 = $_POST['category_order_4'];

      // คำสั่ง SQL สำหรับเพิ่มข้อมูลลงในตาราง recommendation
      $sql = "INSERT INTO recommendation (user_id, Cat_ID, Cat_Score2) VALUES (:user_id, :cat_id, :cat_score2)";

      // สร้างคำสั่ง SQL และทำการเรียก execute สำหรับแต่ละข้อมูล
      $stmt = $conn->prepare($sql);

      // บันทึกข้อมูลตามหัวข้อแต่ละอัน
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

      // บันทึกข้อมูลแต่ละหัวข้อ
      $stmt->bindParam(':cat_id', $category_order_1, PDO::PARAM_INT);
      $stmt->bindParam(':cat_score2', $category_order_1, PDO::PARAM_INT);
      $stmt->execute();

      $stmt->bindParam(':cat_id', $category_order_2, PDO::PARAM_INT);
      $stmt->bindParam(':cat_score2', $category_order_2, PDO::PARAM_INT);
      $stmt->execute();

      $stmt->bindParam(':cat_id', $category_order_3, PDO::PARAM_INT);
      $stmt->bindParam(':cat_score2', $category_order_3, PDO::PARAM_INT);
      $stmt->execute();

      $stmt->bindParam(':cat_id', $category_order_4, PDO::PARAM_INT);
      $stmt->bindParam(':cat_score2', $category_order_4, PDO::PARAM_INT);
      $stmt->execute();

      // บันทึกข้อมูลเรียบร้อยแล้ว
      echo "บันทึกข้อมูลเรียบร้อยแล้ว";
  } else {
      // หากผู้ใช้ไม่ได้ล็อกอิน คุณสามารถเปลี่ยนไปยังหน้าล็อกอินหรือทำการจัดการตามที่คุณต้องการ
      echo "กรุณาล็อกอินก่อนที่จะทำการบันทึกข้อมูล";
  }
}


//เลือกลำดับ รานชื่อ category
  $cat = $conn->query("SELECT * FROM tbl_categories ");
  $cat->execute();

  $allCat = $cat->fetchAll(PDO::FETCH_OBJ);

?>



 <!-- ***** Main Banner Area Start ***** -->

 <div class="about-main-content">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <div class="blur-bg"></div>
            <h2>RECOMMENDATION</h2>
            <div class="line-dec"></div>
            <h4>ป้อนข้อมูลเพื่อค้นหาสถานที่ท่องเที่ยวที่เหมาะสำหรับคุณ</h4>
            <p>
            
            </p>
            <div class="main-button">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Main Banner Area End ***** -->

  <div class="search-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form id="search-form" method="POST" role="search" action="search.php">
                    <div class="row">
                        <div class="col-lg-2">
                            <h4 class="btn btn-primary">เที่ยวชมธรรมชาติ:</h4>
                        </div>
                        <div class="col-lg-4">
                            <fieldset>
                                <select name="category_order_1" class="form-select" aria-label="Default select example" id="chooseLocation1" onChange="this.form.click()">
                                    <option selected>โปรดใส่ลำดับ</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-2">
                            <h4 class="btn btn-primary">เรียนรู้วัฒนธรรมและวิถีชุมชน:</h4>
                        </div>
                        <div class="col-lg-4">
                            <fieldset>
                                <select name="category_order_2" class="form-select" aria-label="Default select example" id="chooseLocation2" onChange="this.form.click()">
                                    <option selected>โปรดใส่ลำดับ</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-2">
                            <h4 class="btn btn-primary">ประวัติศาสตร์และศิลปะ:</h4>
                        </div>
                        <div class="col-lg-4">
                            <fieldset>
                                <select name="category_order_3" class="form-select" aria-label="Default select example" id="chooseLocation3" onChange="this.form.click()">
                                    <option option selected>โปรดใส่ลำดับ</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-2">
                            <h4 class="btn btn-primary">กิจกรรมด้านบันเทิง:</h4>
                        </div>
                        <div class="col-lg-4">
                            <fieldset>
                                <select name="category_order_4" class="form-select" aria-label="Default select example" id="chooseLocation4" onChange="this.form.click()">
                                    <option selected>โปรดใส่ลำดับ</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-lg-12">
                            <fieldset>
                                <button type="submit" name="submit" class="border-button">Search Results</button>
                            </fieldset>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ***** สคริปไว้เงื่อนไข เลือกเลขที่ไม่ซ้ำกัน ***** -->
<script>
    var selectedOptions = [];

    function validateSelection(selectId, otherSelectIds) {
        var selectedValue = document.getElementById(selectId).value;

        // ตรวจสอบว่าผู้ใช้เลือกมากกว่า 4 ตัวเลือกแล้ว
        if (selectedOptions.length >= 4 && !selectedOptions.includes(selectedValue)) {
            alert("คุณเลือกตัวเลือกมากกว่า 4 ตัวเลือกแล้ว");
            document.getElementById(selectId).value = 'โปรดใส่ลำดับ';
            return;
        }

        // ตรวจสอบว่ามีตัวเลือกที่เลือกแล้วหรือไม่
        if (selectedOptions.includes(selectedValue)) {
            alert("คุณเลือกตัวเลือกนี้ไปแล้ว");
            document.getElementById(selectId).value = 'โปรดใส่ลำดับ';
            return;
        }

        // ลบตัวเลือกที่ถูกยกเลิกออกจาก selectedOptions
        if (selectedOptions.includes('โปรดใส่ลำดับ')) {
            var index = selectedOptions.indexOf('โปรดใส่ลำดับ');
            if (index !== -1) {
                selectedOptions.splice(index, 1);
            }
        }

        // เพิ่มหรืออัปเดต selectedOptions
        if (selectedOptions.includes(selectedValue)) {
            var index = selectedOptions.indexOf(selectedValue);
            if (index !== -1) {
                selectedOptions.splice(index, 1);
            }
        }
        selectedOptions.push(selectedValue);

        // ปิดการใช้งานตัวเลือกที่ไม่ได้เลือก
        for (var i = 0; i < otherSelectIds.length; i++) {
            var otherSelectId = otherSelectIds[i];
            if (otherSelectId !== selectId) {
                document.getElementById(otherSelectId).querySelectorAll('option').forEach(function (option) {
                    if (option.value === selectedValue) {
                        option.disabled = true;
                    } else {
                        option.disabled = false;
                    }
                });
            }
        }
    }

    // เรียกใช้ validateSelection เมื่อเปลี่ยนการเลือกในแต่ละช่อง
    document.getElementById('chooseLocation1').addEventListener('change', function () {
        validateSelection('chooseLocation1', ['chooseLocation2', 'chooseLocation3', 'chooseLocation4']);
    });

    document.getElementById('chooseLocation2').addEventListener('change', function () {
        validateSelection('chooseLocation2', ['chooseLocation1', 'chooseLocation3', 'chooseLocation4']);
    });

    document.getElementById('chooseLocation3').addEventListener('change', function () {
        validateSelection('chooseLocation3', ['chooseLocation1', 'chooseLocation2', 'chooseLocation4']);
    });

    document.getElementById('chooseLocation4').addEventListener('change', function () {
        validateSelection('chooseLocation4', ['chooseLocation1', 'chooseLocation2', 'chooseLocation3']);
    });
</script>




<?php require "includes/footer.php"; ?>