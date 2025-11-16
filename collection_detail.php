<?php
include 'db_connect.php';

$collectionId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$collectionSql = "SELECT collection_id, collection_name, description, season
                  FROM collection
                  WHERE collection_id = ?";
$stmt = $conn->prepare($collectionSql);
$stmt->bind_param("i", $collectionId);
$stmt->execute();
$collectionResult = $stmt->get_result();

if ($collectionResult->num_rows === 0) {
    // ถ้าไม่เจอ collection
    $collection = null;
} else {
    $collection = $collectionResult->fetch_assoc();
}

// ดึงชุดใน collection นี้จาก dress_for_rent
$dressSql = "SELECT dress_name, size, color, style, price_rental
             FROM dress_for_rent
             WHERE collection_id = ?";
$dressStmt = $conn->prepare($dressSql);
$dressStmt->bind_param("i", $collectionId);
$dressStmt->execute();
$dressResult = $dressStmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo $collection ? htmlspecialchars($collection['collection_name']) . ' | Collection' : 'Collection not found'; ?>
    </title>
    <link rel="stylesheet" href="css/home_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Parisienne&family=Dancing+Script&family=Libre+Baskerville:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="collection-detail-section">
    <div class="container">
        <?php if (!$collection): ?>
            <h2 class="section-title">Collection not found</h2>
            <p style="text-align:center; margin-top:10px;">
                The collection you are looking for does not exist.
            </p>
        <?php else: ?>
            <div class="collection-detail-header">
                <h1 class="collection-detail-title">
                    <?php echo htmlspecialchars($collection['collection_name']); ?>
                </h1>
                <p class="collection-detail-season">
                    <?php echo htmlspecialchars($collection['season']); ?>
                </p>
                <p class="collection-detail-desc">
                    <?php echo htmlspecialchars($collection['description']); ?>
                </p>
            </div>

            <h3 class="section-subtitle" style="margin-top:30px;">
                Dresses in this collection
            </h3>

            <div class="dress-grid">
                <?php if ($dressResult && $dressResult->num_rows > 0): ?>
                    <?php while ($d = $dressResult->fetch_assoc()): ?>
                        <div class="dress-card">
                            <div class="dress-name">
                                <?php echo htmlspecialchars($d['dress_name']); ?>
                            </div>
                            <div class="dress-meta">
                                Size: <?php echo htmlspecialchars($d['size']); ?>
                                | Color: <?php echo htmlspecialchars($d['color']); ?>
                            </div>
                            <div class="dress-meta">
                                Style: <?php echo htmlspecialchars($d['style']); ?>
                            </div>
                            <div class="dress-price">
                                ฿<?php echo number_format($d['price_rental'], 2); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="margin-top:10px;">
                        There are no dresses assigned to this collection yet.
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

</body>
</html>
<?php $conn->close(); ?>
