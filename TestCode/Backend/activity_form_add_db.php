<?php
include('condb.php');

$activity_name = $_POST['activity_name'];

$sql ="INSERT INTO tbl_activity
    
    (activity_name) 

    VALUES 

    ('$activity_name')";
    
    $result = mysqli_query($con, $sql) or die ("Error in query: $sql " . mysqli_error());
    mysqli_close($con);
    
    if($result){
      echo "<script>";
      echo "alert('สำเร็จ');";
      echo "window.location ='activity.php'; ";
      echo "</script>";
    } else {
      
      echo "<script>";
      echo "alert('ERROR!');";
      echo "window.location ='activity.php'; ";
      echo "</script>";
    }
?>