<?php
include "system/connection.php";
/** @var PDO $db */
$category = $db->query("SELECT * FROM category");
$data = $category->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>category</title>
</head>

<body>
    <div>
        <?php foreach ($data as $d): ?>
            <a href="#"><?= htmlspecialchars($d['nama_kategori']) ?></a>
        <?php endforeach ?>
    </div>
</body>

</html>