<?php
include "../../system/connection.php";

if (isset($_POST['submit'])) {
    $nama_kategori = trim($_POST['nama_kategori']);

    if (empty($nama_kategori)) {
        header("Location: ../../category/create.php?error=empty");
        exit;
    }

    try {
        $sql = "INSERT INTO category (nama_kategori) VALUES (?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$nama_kategori]);

        header("Location: ../../index.php?page=product/index&success=created");
        exit;
    } catch (PDOException $e) {
        // Opsional: log error
        header("Location: ../../category/create.php?error=failed");
        exit;
    }
}
