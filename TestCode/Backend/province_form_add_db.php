<?php
include('condb.php');

$province_name = $_POST['province_name'];

$sql ="INSERT INTO tbl_province
    
    (province_name) 

    VALUES 

    ('$province_name')";
    
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
    mysqli_close($con);
    
    if($result){
      echo "<script>";
      echo "alert('สำเร็จ');";
      echo "window.location ='province.php'; ";
      echo "</script>";
    } else {
      
      echo "<script>";
      echo "alert('ERROR!');";
      echo "window.location ='province.php'; ";
      echo "</script>";
    }
?>