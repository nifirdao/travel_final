<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php

if(isset($_SESSION["username"])) {
    header("location: ".APPURL."");
  }

if (isset($_POST['submit'])) {
    // Get selected activities
    $selectedActivities = $_POST['activities'];
  
    if (!empty($selectedActivities)) {
      // Insert selected activities into user_interest_activities table
      $userId = $_SESSION['user_id']; // Assuming you have stored the user ID in the session
  
      // Build the placeholders for the IN clause
      $placeholders = rtrim(str_repeat('?, ', count($selectedActivities)), ', ');
  
      // Prepare the SQL statement
      $sql = "INSERT INTO user_interest_activities (user_id, activity_id) VALUES ";
      $sql .= "(:user_id, $placeholders)";
  
      $stmt = $pdo->prepare($sql);
  
      // Bind the user_id parameter
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
  
      // Bind the activity_id parameters using a loop
      foreach ($selectedActivities as $key => $activityId) {
        $stmt->bindParam(($key + 1), $activityId, PDO::PARAM_INT);
      }
  
      // Execute the statement
      $stmt->execute();
  
      // Redirect to the next page after successful registration
      header("location: login.php"); // Replace next_page.php with the actual URL
      exit();
    } else {
      echo "<script>alert('โปรดเลือกกิจกรรมที่คุณชื่นชอบอย่างน้อย 1 รายการ');</script>";
    }
  }
?>

<div class="reservation-form">
  <div class="container">
    <div class="row">
      <div class="col-lg-12" >
        <form id="registration-form" name="gs" method="POST" action="register_step3.php">
          <div class="row">
            <div class="col-lg-12"text-center>
              <h4>Register - Step 3</h4>
            </div>
            <div class="col-md-12"text-center>
              <h5>เลือกกิจกรรมที่คุณชื่นชอบ</h5>

            <?php
            $query = "SELECT activity_id, activity_name FROM tbl_activity";
            $result = $conn->query($query);

            if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $activityId = $row['activity_id'];
                $activityName = $row['activity_name'];

                echo '<div class="col-md-12">';
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="checkbox" name="activities[]" value="' . $activityId . '" id="activity-' . $activityId . '">';
                echo '<label class="form-check-label" for="activity-' . $activityId . '">' . $activityName . '</label>';
                echo '</div>';
                echo '</div>';
              }
            }
            ?>

            <!-- ปุ่มย้อนกลับอยู่ฝั่งซ้าย -->
            <div class="col-lg-6">
              <fieldset>
                <button class="secondary-button" onclick="goBack()">ย้อนกลับ</button>
              </fieldset>
            </div>

            <script>
              function goBack() {
                window.location.href = 'register_step2.php';
              }
            </script>

            <!-- ปุ่มลงทะเบียน -->
            <div class="col-lg-12">
              <fieldset>
                <button type="submit" name="submit" class="main-button">ลงทะเบียน</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php require "../includes/footer.php"; ?>
