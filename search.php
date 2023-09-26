<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

if($_SERVER['REQUEST_METHOD'] == "POST") {

    if(empty($_POST['Month_ID ']) OR empty($_POST['Typevisit_ID'])) {
        echo "<script>alert('some inputs are empty');</script>";
      } else {

        $country_id = $_POST['country_id'];
        $price = $_POST['price'];


        $searchs = $conn->query("SELECT * FROM cities WHERE country_id = $country_id 
        AND price < $price");
        $searchs->execute();

        $allSearchs = $searchs->fetchAll(PDO::FETCH_OBJ);


      }

} else {
  header("location: index.php");
}


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
            <h4>ค้นหาสถานที่ท่องเที่ยวที่เหมาะสำหรับคุณ</h4>
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

<?php require "includes/footer.php"; ?>