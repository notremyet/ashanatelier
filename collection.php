<?php
include 'db_connect.php';

// ดึง collection ทั้งหมด
$sql = "SELECT collection_id, collection_name, description, season
        FROM collection
        ORDER BY created_at DESC";
$result = $conn->query($sql);

// mapping รูปให้แต่ละ collection (เดียเปลี่ยน path ตามรูปจริงได้เลย)
$collectionImages = [
    1 => 'images/collection-spring.jpg',
    2 => 'images/collection-winter.jpg',
    3 => 'images/collection-fall.jpg',
    4 => 'images/collection-summer.jpg',
    5 => 'images/collection-custom.jpg',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collections | Ashan Atelier</title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="collection-section">
    <div class="container">
        <h2 class="section-title">Our Collection</h2>
        <p class="section-subtitle">
            Explore our curated wedding dress collections designed for every season and mood.
        </p>

        <div class="collection-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $id = (int)$row['collection_id'];
                        $imgPath = isset($collectionImages[$id])
                            ? $collectionImages[$id]
                            : 'images/default-collection.jpg';
                    ?>
                    <a href="collection_detail.php?id=<?php echo $id; ?>" class="collection-card-link">
                        <div class="collection-card">
                            <div class="collection-img"
                                 style="background-image:url('<?php echo $imgPath; ?>');"></div>
                            <div class="collection-body">
                                <div class="collection-name">
                                    <?php echo htmlspecialchars($row['collection_name']); ?>
                                </div>
                                <div class="collection-season">
                                    <?php echo htmlspecialchars($row['season']); ?>
                                </div>
                                <div class="collection-desc">
                                    <?php echo htmlspecialchars($row['description']); ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="text-align:center; margin-top:20px;">
                    No collections have been created yet.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
