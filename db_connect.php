<?php
// db_connect.php
$host = "localhost";
$user = "root";
$pass = "";              // ถ้ามีรหัสผ่านให้ใส่ตรงนี้
$dbname = "ashanatelier"; // ชื่อ database ตามที่เดียสร้างใน ERD

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8"); // ให้รองรับภาษาไทย
?>
