<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name        = trim($_POST['full_name']);
    $email            = trim($_POST['email']);
    $phone            = trim($_POST['phone']);
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. เช็คค่าว่าง
    if ($full_name === '' || $email === '' || $phone === '' || $password === '' || $confirm_password === '') {
        header("Location: register.php?error=Please fill in all fields.");
        exit();
    }

    // 2. เช็ค password ตรงกันไหม
    if ($password !== $confirm_password) {
        header("Location: register.php?error=Password and confirm password do not match.");
        exit();
    }

    // 3. เช็ค length password (อย่างน้อย 6 ตัว)
    if (strlen($password) < 6) {
        header("Location: register.php?error=Password must be at least 6 characters.");
        exit();
    }

    // 4. เช็ค email ซ้ำไหม
    $checkSql = "SELECT user_id FROM user WHERE email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        header("Location: register.php?error=This email is already registered.");
        exit();
    }

    // 5. Insert user ใหม่ (ตอนนี้ใช้ password ตรง ๆ ให้ match กับ login เดิมของเดียนะ)
    $role = 'Customer';

    $insertSql = "INSERT INTO user (full_name, email, phone, password, role, created_at)
                  VALUES (?, ?, ?, ?, ?, NOW())";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("sssss", $full_name, $email, $phone, $password, $role);

    if ($insertStmt->execute()) {
        // สมัครสำเร็จ → ส่งไปหน้า login
        header("Location: login.php?success=Registered successfully. Please login.");
        exit();
    } else {
        header("Location: register.php?error=Something went wrong. Please try again.");
        exit();
    }
} else {
    // ถ้าไม่ได้มาด้วย POST
    header("Location: register.php");
    exit();
}
?>
