<?php
include 'db_connect.php';

// ดึง 3 ชุดสำหรับ service Rental จาก dress_for_rent
$sql = "SELECT dress_name, size, color, style, price_rental 
        FROM dress_for_rent
        WHERE availability_status = 'Available'
        ORDER BY dfr_id DESC
        LIMIT 3";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rental Service | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="service-detail">
    <div class="container">
        <div class="service-detail-header">
            <h1 class="service-detail-title">Rental</h1>
            <p class="service-detail-text">
                Our Rental service offers a wide selection of ready-made wedding dresses 
                that you can rent for your special day. Each gown is carefully maintained 
                to ensure it looks fresh, elegant, and camera-ready. This option is perfect 
                for brides who want a beautiful designer look with a more flexible budget.
            </p>
        </div>

        <div class="service-gallery">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="service-gallery-card">
                        <div class="service-gallery-img" style="background-image:url('assets/images/sample-rental.jpg');"></div>

                        <div class="service-gallery-title">
                            <?php echo htmlspecialchars($row['dress_name']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Size: <?php echo htmlspecialchars($row['size']); ?>
                            | Color: <?php echo htmlspecialchars($row['color']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Style: <?php echo htmlspecialchars($row['style']); ?>
                        </div>
                        <div class="service-gallery-price">
                            Rental price: ฿<?php echo number_format($row['price_rental'], 2); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No rental dresses available yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
