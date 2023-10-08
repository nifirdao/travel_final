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

    // ตรวจสอบว่าผู้ใช้เลือกสถานที่เที่ยวอย่างน้อยหนึ่งแห่งและไม่เกิน 5 แห่ง
    if (isset($_POST["attraction"]) && is_array($_POST["attraction"])) {
        $selectedAttractions = $_POST["attraction"];

        if (count($selectedAttractions) <= 5) {
            try {
                $conn = new PDO("mysql:host=localhost;dbname=travel", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $conn->beginTransaction();

                foreach ($selectedAttractions as $attractionID) {
                    $stmtInsert = $conn->prepare("INSERT INTO user_visited_places (User_ID, Attrac_ID) VALUES (:user_id, :attrac_id)");
                    $stmtInsert->bindParam(":user_id", $userID, PDO::PARAM_INT);
                    $stmtInsert->bindParam(":attrac_id", $attractionID, PDO::PARAM_INT);
                    $stmtInsert->execute();
                }

                $conn->commit();

                header("location: " . APPURL . ""); //ไปหน้า recommen
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกสถานที่เที่ยว</title>
    <style>
        .attraction-container {
            display: flex;
            flex-wrap: wrap;
        }
        .attraction-item {
            flex-basis: 33.33%;
            padding: 10px;
        }
    </style>
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
                                                <img src="http://localhost/travel/TestCode/backend/attrac_img/<?php echo $attraction['attrac_img']; ?>" width="100">
                                                <div class="attrac-name"><?php echo $attraction['attrac_name']; ?></div>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    <div class="attraction-item">
                                        <label>
                                            <input type="checkbox" name="attraction[]" value="<?php echo $attraction['Attrac_ID']; ?>">
                                            <?php echo $attraction['attrac_name']; ?>
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
