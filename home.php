<?php
include 'db_connect.php';

// ดึง collection
$collectionsSql = "SELECT collection_id, collection_name, description, season
                   FROM collection
                   ORDER BY created_at DESC
                   LIMIT 3";
$collectionsResult = $conn->query($collectionsSql);

// ดึงชุดมาโชว์
$dressSql = "SELECT dfr_id, dress_name, size, color, price_rental
             FROM dress_for_rent
             WHERE availability_status = 'Available'
             ORDER BY dfr_id DESC
             LIMIT 4";
$dressResult = $conn->query($dressSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ashan Atelier | Wedding Dress Rental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<!-- HERO -->
<section class="container hero">
    <div class="hero-text">
        <h1>Ashan Atelier Wedding</h1>
        <h2>Minimal, elegant wedding dresses for your special day.</h2>
        <p>
            We provide contemporary and stylish wedding gowns with high quality fabrics 
            and a warm, personalized service to make sure you feel confident and beautiful.
        </p>
        <div class="hero-actions">
            <a href="collection.php"><button class="btn-filled">View Our Collection</button></a>
            <a href="#services"><button class="btn-outline">Explore Services</button></a>
        </div>
    </div>
    <div class="hero-image"></div>
</section>

<!-- SERVICES -->
<section id="services" class="services">
    <div class="container">
        <h2 class="section-title">Our Services</h2>
        <p class="section-subtitle">Choose the service that matches your dream wedding dress.</p>

        <div class="service-grid">

            <!-- Rental -->
            <a href="service_rental.php" class="service-card-link">
                <div class="service-card">
                    <div class="service-img" style="background-image:url('images/service-rental.jpg');"></div>
                    <div class="service-content">
                        <div class="service-title">Rental</div>
                        <div class="service-tag">For one special day</div>
                        <div class="service-desc">
                            Choose a dress from our curated collection
                            – perfect for brides who want affordability and a wide variety of styles.
                        </div>
                    </div>
                </div>
            </a>

            <!-- Made for Rent -->
            <a href="service_made_for_rent.php" class="service-card-link">
                <div class="service-card">
                    <div class="service-img" style="background-image:url('images/service-made-for-rent.jpg');"></div>
                    <div class="service-content">
                        <div class="service-title">Made for Rent</div>
                        <div class="service-tag">Custom, then join collection</div>
                        <div class="service-desc">
                            Design a new dress tailored to your style and measurements.
                            After use, the dress will be added to our rental collection.
                        </div>
                    </div>
                </div>
            </a>

            <!-- Made to Order -->
            <a href="service_made_to_order.php" class="service-card-link">
                <div class="service-card">
                    <div class="service-img" style="background-image:url('images/service-made-to-order.jpg');"></div>
                    <div class="service-content">
                        <div class="service-title">Made to Order</div>
                        <div class="service-tag">Your dress only</div>
                        <div class="service-desc">
                            Create a dress that is uniquely yours – a piece to treasure.
                            Select fabrics, details, and collaborate on every part of the design.
                        </div>
                    </div>
                </div>
            </a>

        </div>

    </div>
</section>

<!-- COLLECTIONS FROM DB -->
<section id="collections" class="collections">
    <div class="container">
        <h2 class="section-title">Featured Collections</h2>
        <p class="section-subtitle">Curated themes from our dress library.</p>

        <div class="collection-grid">
            <?php if ($collectionsResult && $collectionsResult->num_rows > 0): ?>
                <?php while($row = $collectionsResult->fetch_assoc()): ?>
                    <div class="collection-card">
                        <div class="collection-name">
                            <?php echo htmlspecialchars($row['collection_name']); ?>
                        </div>
                        <div class="collection-season">
                            <?php echo htmlspecialchars($row['season']); ?>
                        </div>
                        <div class="collection-desc">
                            <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; font-size:14px;">
                    No collections available yet.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- DRESSES FROM DB -->
<section class="dresses">
    <div class="container">
        <h2 class="section-title">New Arrivals</h2>
        <p class="section-subtitle">Recently added dresses available for rental.</p>

        <div class="dress-grid">
            <?php if ($dressResult && $dressResult->num_rows > 0): ?>
                <?php while($dress = $dressResult->fetch_assoc()): ?>
                    <div class="dress-card">
                        <div class="dress-name">
                            <?php echo htmlspecialchars($dress['dress_name']); ?>
                        </div>
                        <div class="dress-meta">
                            Size: <?php echo htmlspecialchars($dress['size']); ?>
                            | Color: <?php echo htmlspecialchars($dress['color']); ?>
                        </div>
                        <div class="dress-price">
                            ฿<?php echo number_format($dress['price_rental'], 2); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; font-size:14px;">
                    No dresses available at the moment.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php
$conn->close();
?>
