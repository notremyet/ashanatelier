<?php 
session_start();
include 'db_connect.php'; 
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ดึง user จากตาราง user
    $sql = "SELECT user_id, full_name, email, password, role 
            FROM user 
            WHERE email = ? 
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // ถ้าเดียยังไม่ใช้ password_hash ก็ใช้เทียบตรง ๆ แบบนี้ได้
        if ($password === $row['password']) {
            // เก็บ session
            $_SESSION['user_id']   = $row['user_id'];
            $_SESSION['full_name'] = $row['full_name'];
            $_SESSION['email']     = $row['email'];
            $_SESSION['role']      = $row['role']; // Admin / Customer / Developer

            // redirect ตาม role
            if ($row['role'] === 'Admin') {
                header("Location: admin_dashboard.php");
                exit;
            } elseif ($row['role'] === 'Developer') {
                header("Location: dev_dashboard.php");
                exit;
            } else { // Customer (User)
                header("Location: customer_dashboard.php");
                exit;
            }
        } else {
            $error = "Incorrect email or password.";
        }
    } else {
        $error = "Incorrect email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link rel="stylesheet" href="css/log-reg_style.css">

    <!-- ฟอนต์ที่เดียอยากให้มันดูคลาสสิค -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Log in to continue your journey</p>

        <?php if (!empty($error)): ?>
            <p style="color:#c46c63; text-align:center; margin-bottom:10px;">
                <?php echo htmlspecialchars($error); ?>
            </p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="auth-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="auth-success">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login_btn" class="auth-btn">Login</button>
        </form>

        <p class="auth-footer">
            Don't have an account?
            <a href="register.php">Sign up</a>
        </p>
    </div>
</div>

</body>
</html>
