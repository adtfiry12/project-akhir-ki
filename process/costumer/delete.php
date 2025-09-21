<?php
session_start();
include "../../system/connection.php";

if (!isset($_GET['id'])) {
    die("ID customer tidak ditemukan.");
}

$id = (int)$_GET['id'];

try {
    $stmt = $db->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->execute([$id]);

    echo "<script>alert('Data customer berhasil dihapus'); window.location='../../index.php?page=costumer/index';</script>";
} catch (PDOException $e) {
    die("Gagal menghapus customer: " . $e->getMessage());
}
