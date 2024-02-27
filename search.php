<?php 
require "includes/header.php";
require "config/config.php";
require "ConDb.php";


//**************************** หน้าโชว์ รายละเอียดเพิ่มเติม ข้อมูลสถานที่เที่ยว  *****************************  


if (isset($_GET['attrac_id'])) {
    $attrac_id = $_GET['attrac_id'];

    $attraction = $conn->query("SELECT * FROM tbl_attraction WHERE attrac_id='$attrac_id'");
    $attraction->execute();

    $singleAttraction = $attraction->fetch(PDO::FETCH_OBJ);

    // เช็คว่าพบข้อมูลสถานที่ท่องเที่ยวหรือไม่
    if (!$singleAttraction) {
        // หากไม่พบข้อมูลสถานที่ท่องเที่ยวที่ตรงเงื่อนไข
        header("Location: error.php");
        exit;
    }
} else {
    // หากไม่มี attrac_id ที่ส่งมา
    header("Location: error.php");
    exit;
}
?>

<!-- ***** Main Banner Area Start ***** -->
<div class="about-main-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content">
                    <div class="blur-bg"></div>
                    <h4>EXPLORE OUR RECOMMENDATION</h4>
                    <div class="line-dec"></div>
                    <h2>Welcome To <?php echo $singleAttraction->attrac_name; ?></h2>
                    <p>
                        <?php echo $singleAttraction->attrac_detail; ?>
                    </p>
                    <div class="main-button">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Main Banner Area End ***** -->


<!-- ตรวจสอบค่า $sql และปรับรายละเอียด CSS ตามที่ต้องการ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="css/styles_about.css">
    <!-- ... ตกแต่งกล่องค้นหา ... -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/styles_about.css">
</head>

<main>
    
</main>

<body>

</body>

</html>

<?php require "includes/footer.php"; ?>
