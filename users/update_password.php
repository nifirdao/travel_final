<?php
require "config/config.php"; // เรียกใช้ไฟล์กำหนดค่า

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $id = $_POST['id'];
    $newPassword = $_POST['password'];

    // ตรวจสอบว่ารหัสผ่านไม่ใช่ค่าเริ่มต้น
    if ($newPassword !== '********') {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET mypassword = :mypassword WHERE id = :id";
        $stmtPassword = $conn->prepare($updatePasswordQuery);
        $stmtPassword->execute([
            'mypassword' => $hashedPassword,
            'id' => $id
        ]);
    }

    // รีเฟรชหน้าหลักหรือทำตามที่คุณต้องการ เช่น รีเดิมหน้า edit profile
    header("Location: user.php?id=$id");
    exit;
}
?>
