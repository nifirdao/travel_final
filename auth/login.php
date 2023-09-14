<?php require "../includes/header.php"; ?>
<?php require "../config/config.php"; ?>
<?php 


  if(isset($_SESSION["username"])) {
    header("location: ".APPURL."");
  }
  //take the data from the inputs

  if(isset($_POST['submit'])) {
    
   // ตรวจสอบว่ามีข้อมูลที่กรอกในฟอร์มหรือไม่
    if(empty($_POST['email']) OR empty($_POST['password'])) {
      echo "<script>alert('one or more input are empty');</script>"; //ถ้ามีค่าว่างอยู่ในฟิลด์ email หรือ password จะแสดง Alert แจ้งเตือน
   
    } else {
     // รับข้อมูลจากฟอร์ม
      $email = $_POST['email'];
      $password = $_POST['password'];


      //check for the email with a query first

      $login = $conn->query("SELECT * FROM users WHERE email='$email'");
      $login->execute();

      $fetch = $login->fetch(PDO::FETCH_ASSOC); 

      if($login->rowCount() > 0) {
        ///echo "<script>alert('email is fine');</script>";

        //check for the password with password verfiy
        if(password_verify($password, $fetch['mypassword'])) {

          $_SESSION['username'] = $fetch['username'];
          $_SESSION['user_id'] = $fetch['id'];

          header(("location: ".APPURL.""));
        } else {
          echo "<script>alert('email or password are wrong');</script>";
          // ถ้ารหัสผ่านไม่ถูกต้อง แสดงข้อความแจ้งเตือน
        }

      } else {
        echo "<script>alert('email or password are wrong');</script>";
        // ถ้าไม่พบ email ที่รับมาในฐานข้อมูล แสดงข้อความแจ้งเตือน
      }


    }
  }







?>
  <div class="reservation-form">
    <div class="container">
      <div class="row">
        
        <div class="col-lg-12">
          <form id="reservation-form" method="POST" role="search" action="login.php">
            <div class="row">
              <div class="col-lg-12">
                <h4>Login</h4>
              </div>
              <div class="col-md-12">
                  <fieldset>
                      <label for="Name" class="form-label">Your Email</label>
                      <input type="text" name="email" class="Name" placeholder="email" autocomplete="on" required>
                  </fieldset>
              </div>
             <div class="col-md-12">
                <fieldset>
                    <label for="Name" class="form-label">Your Password</label>
                    <input type="password" name="password" class="Name" placeholder="password" autocomplete="on" required>
                </fieldset>
              </div>
              <div class="col-lg-12">                        
                  <fieldset>
                      <button name="submit" type="submit" class="main-button">login</button>
                  </fieldset>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php require "../includes/footer.php"; ?>