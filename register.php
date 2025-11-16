<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Ashana Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link rel="stylesheet" href="css/log-reg_style.css">

    <!-- ฟอนต์สวย ๆ -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2 class="auth-title">Create Account</h2>
        <p class="auth-subtitle">Join us and start your dress journey.</p>

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

        <form action="process_register.php" method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Phone</label>
            <input type="text" name="phone" required>

            <label>Password</label>
            <input type="password" name="password" required minlength="6">

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required minlength="6">

            <button type="submit" class="auth-btn">Sign Up</button>
        </form>

        <p class="auth-footer">
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>
</div>

</body>
</html>
