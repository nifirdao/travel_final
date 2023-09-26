<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php require "ConDb.php"; ?>
<?php 

  $type = $conn->query("SELECT * FROM tbl_traveler_types ");
  $type->execute();

  $allType = $type->fetchAll(PDO::FETCH_OBJ);



  //grapping month

  $month = $conn->query("SELECT * FROM tbl_month ");
  $month->execute();

  $allMonth = $month->fetchAll(PDO::FETCH_OBJ);

  // var_dump($allMonth);



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
                <h4>Sort Search By:</h4>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                      <select name="month_id" class="form-select" aria-label="Default select example" id="chooseLocation" onChange="this.form.click()">
                          <option selected>Month</option>
                          <?php foreach($allMonth as $monthes) : ?>
                            <option value="<?php echo $monthes->month_id; ?>"><?php echo $monthes->month_name; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-4">
                  <fieldset>
                  <fieldset>
                      <select name="type_id" class="form-select" aria-label="Default select example" id="chooseLocation" onChange="this.form.click()">
                          <option selected>Type</option>
                          <?php foreach($allType as $types) : ?>
                            <option value="<?php echo $types->typevisit_id; ?>"><?php echo $types->typevisit_name; ?></option>
                          <?php endforeach; ?>
                      </select>
                  </fieldset>
              </div>
              <div class="col-lg-2">                        
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


<?php require "includes/footer.php"; ?>