<?php
include "system/connection.php";

// === AMBIL CATEGORY ===
$id_category = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Ambil SEMUA kategori tanpa cek stok
$stmtCat = $db->query("SELECT * FROM category ORDER BY nama_kategori");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// === AMBIL PRODUK ===
if ($id_category > 0) {
    // Ambil produk per kategori (stok berapapun)
    $stmtProd = $db->prepare("SELECT * FROM products WHERE category_id = :category_id");
    $stmtProd->execute([':category_id' => $id_category]);
} else {
    // Ambil semua produk tanpa cek stok
    $stmtProd = $db->query("SELECT * FROM products");
}
$products = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
