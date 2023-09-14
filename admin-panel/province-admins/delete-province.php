<?php require "../layouts/header.php"; ?>      
<?php require "../../config/config.php"; ?> 

<?php 

  if(!isset($_SESSION["adminname"])) {
    header("location: ".ADMINURL."");
  }

  if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $image_delete = $conn->query("SELECT * FROM tbl_province WHERE id='$id'");
    $image_delete->execute();
  
    $getImage = $image_delete->fetch(PDO::FETCH_OBJ);

    unlink("images_province/" . $getImage->image);


    //delete

    $deleteRecord = $conn->query("DELETE FROM tbl_province WHERE id='$id'");
    $deleteRecord->execute();

    header("location: show-province.php");
    
  }  
  


?> 
