<?php
session_start();
include 'db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // ถ้าใน DB ยังไม่ใช้ password hash → ใช้วิธีตรงก่อน
    if ($password === $user['password']) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['fullname'] = $user['full_name'];

        // redirect ตาม role
        if ($user['role'] == 'Admin') {
            header("Location: admin_dashboard.php");
        } else if ($user['role'] == 'Developer') {
            header("Location: dev_panel.php");
        } else {
            header("Location: home.php");
        }
        exit();
    }
}

// login fail
header("Location: login.php?error=Invalid email or password");
exit();

?>
