<?php
// components/header.php
?>
<header>
    <div class="container navbar">
        <!-- LOGO คลิกแล้วกลับหน้า Home -->
        <a href="home.php" class="logo-link">
            <div class="logo-circle"></div>
            <div class="logo-text">Ashan Atelier</div>
        </a>
        <nav class="nav-links">
            <a href="home.php">Home</a>
            <a href="home.php#services">Services</a>
            <a href="collection.php">Collections</a>
            <a href="home.php#contact">Contact</a>
        </nav>
        <div class="nav-auth">
            <a href="login.php"><button class="btn-outline">Login</button></a>
            <a href="register.php"><button class="btn-filled">Sign Up</button></a>
        </div>
    </div>
</header>
