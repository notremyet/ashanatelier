<?php
include 'db_connect.php';

// ดึง 3 ชุดจากตาราง made_for_rent_dress
$sql = "SELECT design_name, color, style, fabric_type, size_snapshot, rental_price 
        FROM made_for_rent_dress
        ORDER BY mfr_id DESC
        LIMIT 3";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Made for Rent | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="service-detail">
    <div class="container">
        <div class="service-detail-header">
            <h1 class="service-detail-title">Made for Rent</h1>
            <p class="service-detail-text">
                With our Made for Rent service, you can design a custom dress together with our 
                designer and wear it as the very first bride. After your event, the gown will 
                be added to our rental collection, allowing other brides to enjoy your unique design.
                This option is ideal for brides who want something special while still maximising value.
            </p>
        </div>

        <div class="service-gallery">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="service-gallery-card">
                        <div class="service-gallery-img" style="background-image:url('assets/images/sample-made-for-rent.jpg');"></div>

                        <div class="service-gallery-title">
                            <?php echo htmlspecialchars($row['design_name']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Color: <?php echo htmlspecialchars($row['color']); ?>
                            | Style: <?php echo htmlspecialchars($row['style']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Fabric: <?php echo htmlspecialchars($row['fabric_type']); ?>
                        </div>
                        <div class="service-gallery-meta">
                            Size snapshot: <?php echo htmlspecialchars($row['size_snapshot']); ?>
                        </div>
                        <div class="service-gallery-price">
                            Estimated rental price: ฿<?php echo number_format($row['rental_price'], 2); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No made-for-rent designs have been created yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
