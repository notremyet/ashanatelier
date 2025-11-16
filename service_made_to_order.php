<?php
include 'db_connect.php';

// ดึง 3 ตัวอย่างจาก made_to_order_dress
$sql = "SELECT dress_name, color, style, fabric_type, embellishment, price 
        FROM made_to_order_dress
        ORDER BY mto_id DESC
        LIMIT 3";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Made to Order | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="service-detail">
    <div class="container">
        <div class="service-detail-header">
            <h1 class="service-detail-title">Made to Order</h1>
            <p class="service-detail-text">
                Our Made to Order service is designed for brides who dream of a one-of-a-kind gown. 
                Together with our designer, you can choose the silhouette, fabric, and details to match 
                your personality and wedding theme. The dress is created to your exact measurements 
                and is kept exclusively for you.
            </p>
        </div>

        <div class="service-gallery">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="service-gallery-card">
                        <div class="service-gallery-img" style="background-image:url('assets/images/sample-made-to-order.jpg');"></div>

                        <div class="service-gallery-title">
                            <?php echo htmlspecialchars($row['dress_name']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Color: <?php echo htmlspecialchars($row['color']); ?>
                            | Style: <?php echo htmlspecialchars($row['style']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Fabric: <?php echo htmlspecialchars($row['fabric_type']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Embellishment: <?php echo htmlspecialchars($row['embellishment']); ?>
                        </div>
                        <div class="service-gallery-price">
                            Made-to-order price: ฿<?php echo number_format($row['price'], 2); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No made-to-order dresses have been recorded yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
