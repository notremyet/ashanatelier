<?php
session_start();
include 'db_connect.php';

// ถ้าไม่ได้ล็อกอิน หรือ role ไม่ใช่ Customer → ส่งกลับหน้า login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Customer') {
    header("Location: login.php");
    exit;
}

$userId   = $_SESSION['user_id'];
$fullName = $_SESSION['full_name'];

// ดึงคำสั่งซื้อของ user ล่าสุด 5 orders
$orderSql = "SELECT o.order_id, o.order_date, o.order_type, o.status, p.amount
             FROM orders o
             LEFT JOIN payment p ON p.order_id = o.order_id
             WHERE o.user_id = ?
             ORDER BY o.order_date DESC
             LIMIT 5";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$orderResult = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="account-section">
    <div class="container">

        <div class="account-header">
            <h1 class="account-title">Welcome back, <?php echo htmlspecialchars($fullName); ?> ✨</h1>
            <p class="account-subtitle">
                Here is a quick overview of your reservations and orders.
            </p>
        </div>

        <div class="account-grid">
            <!-- card 1: profile summary -->
            <div class="account-card">
                <h3 class="account-card-title">My Profile</h3>
                <p>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p>Role: Customer</p>
                <a href="profile.php" class="account-link">View or edit profile →</a>
            </div>

            <!-- card 2: measurement (placeholder ตอนนี้) -->
            <div class="account-card">
                <h3 class="account-card-title">Measurements</h3>
                <p>Manage your measurement profile used for Made-to-order and Made-for-rent dresses.</p>
                <a href="measurements.php" class="account-link">Manage measurements →</a>
            </div>
        </div>

        <div class="account-orders">
            <h2 class="account-subheading">Recent Orders</h2>

            <?php if ($orderResult && $orderResult->num_rows > 0): ?>
                <table class="account-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Amount (฿)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orderResult->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo htmlspecialchars($row['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['order_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo number_format($row['amount'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You don’t have any orders yet.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
