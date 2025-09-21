<?php
include "system/connection.php";

// === AMBIL CATEGORY ===
$id_category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Ambil hanya kategori yang punya produk stok > 0
$stmtCat = $db->query("
    SELECT DISTINCT c.*
    FROM category c
    JOIN products p ON p.category_id = c.id
    WHERE p.stok > 0
    ORDER BY c.nama_kategori
");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// === AMBIL PRODUK ===
if ($id_category > 0) {
    // Produk difilter per kategori + stok > 0
    $stmtProd = $db->prepare("SELECT * FROM products WHERE category_id = :category_id AND stok > 0");
    $stmtProd->execute([':category_id' => $id_category]);
} else {
    // Semua produk stok > 0
    $stmtProd = $db->query("SELECT * FROM products WHERE stok > 0");
}
$products = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
