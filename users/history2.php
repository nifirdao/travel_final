<?php
require "../includes/header.php";
require "../config/config.php";
require "../ConDb.php"; 

// ตรวจสอบว่าผู้ใช้ล็อกอินเรียบร้อยและมี User_ID ใน $_SESSION
if (!isset($_SESSION["username"])) {
    header("location: " . APPURL . "");
    exit();
}

$query = "SELECT attrac_name, attrac_detail, attrac_img FROM tbl_attraction WHERE attrac_id = attrac_id";
$result = mysqli_query($con, $query);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];

    if (isset($_POST["attraction"]) && is_array($_POST["attraction"])) {
        $selectedAttractions = $_POST["attraction"];
    
        if (count($selectedAttractions) <= 5) {
            try {
                $conn->beginTransaction();
    
                foreach ($selectedAttractions as $attractionID) {
                    // ดึงชื่อสถานที่เที่ยวจากตาราง tbl_attraction
                    $stmtSelectAttraction = $conn->prepare("SELECT attrac_name FROM tbl_attraction WHERE Attrac_ID = :attrac_id");
                    $stmtSelectAttraction->bindParam(":attrac_id", $attractionID, PDO::PARAM_INT);
                    $stmtSelectAttraction->execute();
                    $attractionName = $stmtSelectAttraction->fetchColumn();
    
                    // ตรวจสอบว่ามีข้อมูลในตาราง user_visited_places หรือไม่
                    $stmtSelect = $conn->prepare("SELECT * FROM user_visited_places WHERE User_ID = :user_id AND Attrac_ID = :attrac_id");
                    $stmtSelect->bindParam(":user_id", $userID, PDO::PARAM_INT);
                    $stmtSelect->bindParam(":attrac_id", $attractionID, PDO::PARAM_INT);
                    $stmtSelect->execute();
                    $existingRecord = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    
                    if ($existingRecord) {
                        // อัปเดต Attrac_ID และ attrac_name ที่มีอยู่
                        $stmtUpdate = $conn->prepare("UPDATE user_visited_places SET Attrac_ID = :attrac_id, attrac_name = :attrac_name WHERE User_ID = :user_id AND Visit_ID = :visit_id");
                        $stmtUpdate->bindParam(":attrac_id", $attractionID, PDO::PARAM_INT);
                        $stmtUpdate->bindParam(":attrac_name", $attractionName, PDO::PARAM_STR);
                        $stmtUpdate->bindParam(":user_id", $userID, PDO::PARAM_INT);
                        $stmtUpdate->bindParam(":visit_id", $visitID, PDO::PARAM_INT);
                        $stmtUpdate->execute();
                    } else {
                        // เพิ่มข้อมูลใหม่
                        $stmtInsert = $conn->prepare("INSERT INTO user_visited_places (User_ID, Attrac_ID, attrac_name) VALUES (:user_id, :attrac_id, :attrac_name)");
                        $stmtInsert->bindParam(":user_id", $userID, PDO::PARAM_INT);
                        $stmtInsert->bindParam(":attrac_id", $attractionID, PDO::PARAM_INT);
                        $stmtInsert->bindParam(":attrac_name", $attractionName, PDO::PARAM_STR);
                        $stmtInsert->execute();

                    }
                }

                 // เพิ่มโค้ดเพื่อลบข้อมูลเก่าเมื่อผู้ใช้เลือกสถานที่เที่ยวเกิน 5 แห่ง **ไว้ลบข้อมูลที่เยอะตามมาในอนาคต
                 
                // ตรวจสอบว่ามีข้อมูลในตาราง user_visited_places หรือไม่
                    $stmtSelect = $conn->prepare("SELECT * FROM user_visited_places WHERE User_ID = :user_id");
                    $stmtSelect->bindParam(":user_id", $userID, PDO::PARAM_INT);
                    $stmtSelect->execute();
                    $records = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

                    // ตรวจสอบจำนวนเร็คคอร์ด
                    if (count($records) > 5) {
                        // เรียงลำดับเร็คคอร์ดตาม Visit_ID ในลำดับล่าสุด
                        usort($records, function($a, $b) {
                            return $b['Visit_ID'] - $a['Visit_ID'];
                        });

                        // ลบเร็คคอร์ดที่มากกว่า 10 รายการ
                        $recordsToDelete = array_slice($records, 10);
                        foreach ($recordsToDelete as $record) {
                            $stmtDelete = $conn->prepare("DELETE FROM user_visited_places WHERE Visit_ID = :visit_id");
                            $stmtDelete->bindParam(":visit_id", $record['Visit_ID'], PDO::PARAM_INT);
                            $stmtDelete->execute();
                        }
                    }

    
                $conn->commit();
    
                echo "<script>alert('บันทึกคะแนนสำเร็จ');</script>";

                // เพิ่มโค้ดเพื่อเปลี่ยนเส้นทางไปยังหน้า "Recommendation" หลังจากบันทึกคะแนนสำเร็จ
                echo "<script>window.location.href = '" . APPURL . "/recommendation.php';</script>";        

                exit();
            } catch (PDOException $e) {
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "<script>alert('คุณสามารถเลือกสถานที่เที่ยวได้ไม่เกิน 5 แห่ง');</script>";
        }
    }
}    


// ดึงข้อมูลสถานที่เที่ยวจากตาราง tbl_attraction
try {
    $conn = new PDO("mysql:host=localhost;dbname=travel", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT Attrac_ID, attrac_name FROM tbl_attraction");
    $stmt->execute();
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... ตกแต่งกล่องค้นหา ... -->
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="reservation-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="reservation-form" name="gs" method="POST" action="history2.php">
                        <div class="col-md-12">
                            <h5>เลือกสถานที่เที่ยว (ไม่เกิน 5 แห่ง)</h5>
                            <input type="text" id="searchAttraction" placeholder="ค้นหาสถานที่เที่ยว">
                            <div class="attraction-container">
                                <?php foreach ($attractions as $attraction) { ?>
                                    <div class="attraction-item">
                                        <label>
                                            <input type="checkbox" name="attraction[]" value="<?php echo $attraction['Attrac_ID']; ?>">
                                            <div class="attraction-info">
                                            <?php
                                                    $row = mysqli_fetch_array($result);
                                                    $attrac_name = $row['attrac_name'];
                                                    // แสดงสถานที่ท่องเที่ยวเป็นตัวเลือก
                                                    echo "<img src='http://localhost/travel/TestCode/backend/attrac_img/".$row["attrac_img"]."' width='100'>";
                                                    echo '<h3>' . $attrac_name . '</h3>';    
                                                    ?>
                                            </div>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">บันทึกสถานที่เที่ยว</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        // JavaScript เพื่อควบคุมการค้นหาและการเลือกสถานที่เที่ยว
        document.addEventListener("DOMContentLoaded", function () {
            const searchAttraction = document.getElementById("searchAttraction");
            const attractionItems = document.querySelectorAll(".attraction-item");

            searchAttraction.addEventListener("input", function () {
                const searchText = this.value.toLowerCase();

                attractionItems.forEach(function (item) {
                    const label = item.querySelector("label");
                    const attractionName = label.textContent.toLowerCase();

                    if (attractionName.includes(searchText)) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                    }
                });
            });

            const checkboxInputs = document.querySelectorAll("input[type='checkbox']");
            checkboxInputs.forEach(function (checkbox) {
                checkbox.addEventListener("change", function () {
                    const selectedCheckboxes = document.querySelectorAll("input[type='checkbox']:checked");
                    if (selectedCheckboxes.length > 5) {
                        this.checked = false;
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php require "../includes/footer.php"; ?>
