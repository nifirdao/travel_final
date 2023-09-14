<?php require "layouts/header.php"; ?>      
<?php require "../config/config.php"; ?>      
<?php
            
  if(!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."/admins/login-admins.php");
  } 
  

  $province = $conn->query("SELECT COUNT(*) AS province_count FROM tbl_province");
  $province->execute();

  $allProvince = $province->fetch(PDO::FETCH_OBJ);


  $attraction = $conn->query("SELECT COUNT(*) AS attraction_count FROM tbl_attraction");
  $attraction->execute();

  $allAttraction = $attraction->fetch(PDO::FETCH_OBJ);


  $admins = $conn->query("SELECT COUNT(*) AS admins_count FROM admins");
  $admins->execute();

  $allAdmins = $admins->fetch(PDO::FETCH_OBJ);



  $register = $conn->query("SELECT COUNT(*) AS register_count FROM register");
  $register->execute();

  $allRegister = $register->fetch(PDO::FETCH_OBJ);


  
?>
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Province</h5>
              <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
              <p class="card-text">number of province: <?php echo $allProvince->province_count; ?></p>
             
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Attraction</h5>
              
              <p class="card-text">number of attraction: <?php echo $allAttraction->attraction_count; ?></p>
              
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Admins</h5>
              
              <p class="card-text">number of admins: <?php echo  $allAdmins->admins_count; ?></p>
              
            </div>
          </div>
        </div>


        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Register</h5>
              
              <p class="card-text">number of register: <?php echo $allRegister->register_count; ?></p>
              
            </div>
          </div>
        </div>
      </div>
   
 <?php require "layouts/footer.php"; ?>      
