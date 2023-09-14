 <!-- <link rel="stylesheet" href="style.css">  เปลี่ยนเป็นพาทที่เก็บไฟล์ CSS ของคุณ -->
<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 

    if (!isset($_SESSION["username"])) {
        header("location: " . APPURL . "");
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $user_result = $conn->query("SELECT * FROM users WHERE id='$id' LIMIT 1");
        $user = $user_result->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            header("location: 404.php");
            exit;
        }
    } else {
        header("location: 404.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
      // ดึงค่าจากฟอร์ม
      $newUsername = $_POST['username'];
      $newEmail = $_POST['email'];
      $newPassword = $_POST['new_password']; // รับรหัสผ่านใหม่

      // ตรวจสอบการอัปเดตค่า username
      if ($newUsername !== $user['username']) {
        $updateUsernameQuery = "UPDATE users SET username = :username WHERE id = :id";
        $stmtUsername = $conn->prepare($updateUsernameQuery);
        $stmtUsername->execute([
            'username' => $newUsername,
            'id' => $id
        ]);

        // อัปเดตค่าในหน้า
        $user['username'] = $newUsername;
    }

    // ตรวจสอบการอัปเดตค่า email
  if ($newEmail !== $user['email']) {
        $updateEmailQuery = "UPDATE users SET email = :email WHERE id = :id";
        $stmtEmail = $conn->prepare($updateEmailQuery);
        $stmtEmail->execute([
            'email' => $newEmail,
            'id' => $id
        ]);

        // อัปเดตค่าในหน้า
        $user['email'] = $newEmail;
    }

  // ตรวจสอบการอัปเดตรหัสผ่าน
if (!empty($newPassword)) {
    // รหัสผ่านใหม่ไม่ว่าง
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updatePasswordQuery = "UPDATE users SET mypassword = :mypassword WHERE id = :id";
    $stmtPassword = $conn->prepare($updatePasswordQuery);
    $stmtPassword->execute([
        'mypassword' => $hashedPassword,
        'id' => $id
    ]);
  }

    // รีเฟรชหน้า
    header("Refresh:0");

    // เรียกใช้งานฟังก์ชันเพื่อแสดงเอฟเฟกต์หรือข้อความแจ้งเตือน
    echo "<script>showUpdateSuccess();</script>";
  }


?>

<div class="reservation-form">
    <div class="container">
      <div class="row">
        
     <div class="col-lg-12">
    <form id="reservation-form" name="gs" method="POST" role="search" onsubmit="showUpdateSuccess()">
        <div class="row">
            <div class="col-lg-12">
                <h4>Edit Profile</h4>
            </div>
            <div class="col-md-12">
                <fieldset>
                    <label for="Name" class="form-label">Your Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>"><br><br>
                </fieldset>
            </div>

            <div class="col-md-12">
                <fieldset>
                    <label for="Name" class="form-label">Your Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><br><br>
                </fieldset>
            </div>

            <div class="col-md-12">
                <fieldset>
                    <label for="Name" class="form-label">Your Password</label>
                    <input type="password" name="new_password" class="password" placeholder="Enter new password" autocomplete="on">
                    <input type="hidden" name="old_password" value="<?php echo htmlspecialchars($user['mypassword']); ?>">
                </fieldset>
            </div>

            <div class="col-lg-12">                        
                <fieldset>
                    <button type="submit" name="update" class="main-button">Update Profile</button>
                </fieldset>
            </div>

              </div>
                </form>
                  </div>
                    <!-- เพิ่มส่วน Javascript เพื่อแสดงข้อความแจ้งเตือน -->
                      <script>
                          function showUpdateSuccess() {
                          // แสดงข้อความหรือเอฟเฟกต์ที่คุณต้องการ เช่น โชว์ข้อความ "Update Success!" ในแบนเนอร์
                          alert("Update Success!");
                          }
                      </script>

                  </div>
                </form>
              </div>
      </div>
    </div>
  </div>

<?php require "../includes/footer.php"; ?>
