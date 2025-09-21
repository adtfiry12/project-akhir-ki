<?php
include "../../system/connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    try {
        $stmt = $db->prepare("DELETE FROM product WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: ../../index.php?page=product/index");
        exit;
    } catch (PDOException $e) {
        header("Location: ../../index.php?page=product/index&error=delete");
        exit;
    }
} else {
    header("Location: ../../index.php?page=product/index");
    exit;
}
