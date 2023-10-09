<?php
require "includes/header.php";
require "config/config.php";
require "ConDb.php";

// ตรวจสอบว่าผู้ใช้ล็อกอินเรียบร้อยและมี User_ID ใน $_SESSION
if (!isset($_SESSION["username"])) {
    header("location: " . APPURL . "");
    exit();
}


$query = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE attrac_id = attrac_id";
$result = mysqli_query($con, $query);

    // ตรวจสอบการล็อกอินของผู้ใช้และรับ user_id ของผู้ใช้ที่ล็อกอิน
    if (isset($_SESSION['user_id'])) {
        $user_id_logged_in = $_SESSION['user_id'];

    
        // ค้นหา user_id ที่มี Cat_Score ที่เชื่อมโยงกับ Cat_ID C1, C2, C3, และ C4 ข้อมูลเรียงกัน ตรงกัน
        $sql = "SELECT user_id
        FROM user_category_scores
        WHERE user_id != 17
        AND user_id IN (
            SELECT user_id
            FROM user_category_scores
            WHERE (Cat_ID = 'C1' AND Cat_Score = (
                SELECT Cat_Score
                FROM user_category_scores
                WHERE user_id = 17
                AND Cat_ID = 'C1'
            ))
            OR (Cat_ID = 'C2' AND Cat_Score = (
                SELECT Cat_Score
                FROM user_category_scores
                WHERE user_id = 17
                AND Cat_ID = 'C2'
            ))
            OR (Cat_ID = 'C3' AND Cat_Score = (
                SELECT Cat_Score
                FROM user_category_scores
                WHERE user_id = 17
                AND Cat_ID = 'C3'
            ))
            OR (Cat_ID = 'C4' AND Cat_Score = (
                SELECT Cat_Score
                FROM user_category_scores
                WHERE user_id = 17
                AND Cat_ID = 'C4'
            ))
            GROUP BY user_id
            HAVING COUNT(DISTINCT Cat_ID) = 4
        )
        
        
        ;
        ";

        
     // เตรียมคำสั่ง SQL
     $stmt = $conn->prepare($sql);
     $stmt->bindParam(':user_id_logged_in', $user_id_logged_in, PDO::PARAM_INT); // ระบุ user_id ของผู้ใช้ที่ล็อกอิน
 
    // ดำเนินการคิวรี่
    $stmt->execute();


    // ตรวจสอบว่ามี user_id ที่ตรงกันหรือไม่
    if ($stmt->rowCount() > 0) {
        // สร้างอาร์เรย์เพื่อเก็บ user_id ที่มี Cat_Score ตรงกับผู้ใช้ที่ล็อกอิน
        $userIdsWithMatchingCatScore = [];
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_id_match = $row['user_id'];

            // สร้างคำสั่ง SQL เพื่อค้นหา Attrac_ID ที่ไม่ซ้ำกันระหว่าง user_id_logged_in และ user_id_match
            $sql_attractions = "SELECT a.attrac_id, b.attrac_name 
                                FROM user_visited_places a
                                INNER JOIN tbl_attraction b ON a.attrac_id = b.attrac_id
                                WHERE a.user_id = :user_id_match 
                                AND a.attrac_id NOT IN (
                                    SELECT attrac_id 
                                    FROM user_visited_places
                                    WHERE user_id = :user_id_logged_in
                                )";

            // เตรียมคำสั่ง SQL
            $stmt_attractions = $conn->prepare($sql_attractions);
            $stmt_attractions->bindParam(':user_id_match', $user_id_match, PDO::PARAM_INT);
            $stmt_attractions->bindParam(':user_id_logged_in', $user_id_logged_in, PDO::PARAM_INT);

            // ดำเนินการคิวรี่
            $stmt_attractions->execute();
        
            }
        } else {
            // ถ้าไม่มี user_id ที่มี Cat_Score ตรงกับผู้ใช้ที่ล็อกอิน
            echo "<script>alert('ยังไม่มีข้อมูลที่ตรงกัน!! โปรดใส่ข้อมูลเพิ่มเติม');</script>";


            // เพิ่มโค้ดเพื่อเปลี่ยนเส้นทางไปยังหน้า "history2" หลังจากบันทึกคะแนน
            echo "<script>window.location.href = '" . APPURL . "/users/history.php?id=" . $_SESSION['user_id'] . "';</script>";
            

        }
    } 
    else {
        // กรณีไม่มีการล็อกอิน
        echo "คุณไม่ได้ล็อกอิน";
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
                    <h4>สถานที่ท่องเที่ยวที่เหมาะสำหรับคุณ</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->

        <!-- นี่คือลูกศรที่ใช้เลื่อนลงข้างล่าง -->
                <div class="col-md-12 text-center">
                <p style=" color:  #22b3c1;" ><i class="fa fa-angle-double-down " aria-hidden="true"></i> สถานที่ท่องเที่ยวที่เหมาะสำหรับคุณ</p>
                </div>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/styles_about.css">
</head>

<main>
   <!-- ... สร้างฟอร์มกล่องเริ่มต้นแนะนำ ... -->
   <div class="col-md-12 text-center">
    <section class="recommendation-button">
        <button onclick="location.href='<?php echo APPURL; ?>/users/history.php?id=<?php echo $_SESSION['user_id']; ?>';" class="btn-recommend">
        <div class="animation">
                <div class="circle"></div>
        <span>เริ่มต้นแนะนำ</span>
            <div class="btn-icon">
                <div class="icon-line top"></div>
                <div class="icon-line bottom"></div>
            </div>
        </button>
    </section>
</div>


  <section class="places-container">
    <?php
    
if ($stmt_attractions->rowCount() > 0) {
    // หากมีข้อมูลสถานที่ท่องเที่ยว
  
        // ตรวจสอบว่า user_id ยังไม่ถูกเพิ่มในอาร์เรย์
        array_push($userIdsWithMatchingCatScore, $user_id_match);
    // แสดงข้อมูลสถานที่ท่องเที่ยว
    while ($attraction = $stmt_attractions->fetch(PDO::FETCH_ASSOC)) {
    $attrac_id = $attraction['attrac_id'];
    $attrac_name = $attraction['attrac_name'];
    $row = mysqli_fetch_array($result);
    // แสดงข้อมูลสถานที่เที่ยว
    echo '<div class="place">';
    echo '<div class="place-img-box">';
    echo "<td align=center>"."<img src='http://localhost/travel/TestCode/backend/attrac_img/".$row["attrac_img"]."' width='100'>"."</td>";
    echo '</div>';
    echo '<div class="place-info">';
    echo '<h3>' . $attrac_name . '</h3>';
    echo '<p>' . $attrac_id . '</p>';
    echo '</div>';
    echo '</div>';
    }
}
    else {
        // ไม่พบข้อมูลในการค้นหา
        echo "<script>alert('ไม่พบข้อมูล');</script>";
        // เพิ่มโค้ดเพื่อเปลี่ยนเส้นทางไปยังหน้า "history2" หลังจากบันทึกคะแนน
            echo "<script>window.location.href = '" . APPURL . "/users/history.php?id=" . $_SESSION['user_id'] . "';</script>";
        exit();
    }
?>
  </section>
</main>
<body>
    <script>
   

    </script>
</body>
</html>




<?php require "includes/footer.php"; ?>
