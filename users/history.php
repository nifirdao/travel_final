<?php
require "../includes/header.php";
require "../config/config.php";

// ตรวจสอบว่าผู้ใช้ไม่ได้ล็อกอิน ถ้าไม่ได้ล็อกอินให้เปลี่ยนเส้นทางไปหน้า APPURL หรือที่ต้องการ
if (!isset($_SESSION["username"])) {
    header("location: " . APPURL . "");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = $_SESSION["user_id"];
    
    if (
        isset($_POST["nature"]) &&
        isset($_POST["culture"]) &&
        isset($_POST["history"]) &&
        isset($_POST["entertainment"])
    ) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=travel", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conn->beginTransaction();

            // ตรวจสอบว่ามีข้อมูลในตาราง user_category_scores สำหรับผู้ใช้งานนี้หรือไม่
            $stmtSelect = $conn->prepare("SELECT * FROM user_category_scores WHERE User_ID = :user_id");
            $stmtSelect->bindParam(":user_id", $userID, PDO::PARAM_INT);
            $stmtSelect->execute();
            $existingScores = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);

            if (count($existingScores) > 0) {
                // ถ้ามีข้อมูลในตาราง ให้อัปเดตคะแนนที่มีอยู่
                $stmtUpdate = $conn->prepare("UPDATE user_category_scores SET Cat_Score = :cat_score WHERE User_ID = :user_id AND Cat_ID = :cat_id");
                $stmtUpdate->bindParam(":user_id", $userID, PDO::PARAM_INT);

                $catScores = [
                    "C1" => $_POST["nature"],
                    "C2" => $_POST["culture"],
                    "C3" => $_POST["history"],
                    "C4" => $_POST["entertainment"],
                ];

                foreach ($catScores as $catID => $score) {
                    $stmtUpdate->bindParam(":cat_id", $catID, PDO::PARAM_STR);
                    $stmtUpdate->bindParam(":cat_score", $score, PDO::PARAM_INT);
                    $stmtUpdate->execute();
                }
            } else {
                // ถ้าไม่มีข้อมูลในตาราง ให้เพิ่มข้อมูลใหม่
                $stmtInsert = $conn->prepare("INSERT INTO user_category_scores (User_ID, Cat_ID, Cat_Score) VALUES (:user_id, :cat_id, :cat_score)");
                $stmtInsert->bindParam(":user_id", $userID, PDO::PARAM_INT);

                $catScores = [
                    "C1" => $_POST["nature"],
                    "C2" => $_POST["culture"],
                    "C3" => $_POST["history"],
                    "C4" => $_POST["entertainment"],
                ];

                foreach ($catScores as $catID => $score) {
                    $stmtInsert->bindParam(":cat_id", $catID, PDO::PARAM_STR);
                    $stmtInsert->bindParam(":cat_score", $score, PDO::PARAM_INT);
                    $stmtInsert->execute();
                }
            }

            $conn->commit();

            echo "<script>alert('บันทึกคะแนนสำเร็จ');</script>";

            header("location: " . APPURL . ""); //ไว้ไปหน้า history2.php กรอกสถานที่ที่เคยไป
            exit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกคะแนน</title>
</head>
<body>
    <div class="reservation-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <form id="reservation-form" name="gs" method="POST" action="history.php">
                        <div class="col-md-12">
                            <h5>คะแนนหมวดหมู่สถานที่</h5>
                            <div class="form-group">
                                <label for="nature">เที่ยวธรรมชาติ:</label>
                                <input type="number" name="nature" class="form-control" min="1" max="4" required>
                            </div>
                            <div class="form-group">
                                <label for="culture">เรียนรู้วัฒนธรรม:</label>
                                <input type="number" name="culture" class="form-control" min="1" max="4" required>
                            </div>
                            <div class="form-group">
                                <label for="history">ประวัติศาสตร์:</label>
                                <input type="number" name="history" class="form-control" min="1" max="4" required>
                            </div>
                            <div class="form-group">
                                <label for="entertainment">กิจกรรมด้านบันเทิง:</label>
                                <input type="number" name="entertainment" class="form-control" min="1" max="4" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">บันทึกคะแนน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php require "../includes/footer.php"; ?>
