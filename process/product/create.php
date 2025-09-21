<?php
include "../../system/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul        = trim($_POST['judul']);
    $penulis      = trim($_POST['penulis']);
    $penerbit     = trim($_POST['penerbit']);
    $tahun_terbit = (int)$_POST['tahun_terbit'];
    $harga        = (int)$_POST['harga'];
    $stok         = (int)$_POST['stok'];
    $category_id  = (int)$_POST['category_id'];

    if (
        empty($judul) || empty($penulis) || empty($penerbit) ||
        empty($tahun_terbit) || empty($harga) || empty($stok) || empty($category_id)
    ) {
        die("
        <script>alert('Wajib diisi semua'); history.back();</script>");
    }


    try {
        // Query insert tanpa kolom gambar
        $sql = "INSERT INTO products 
                (judul, penulis, penerbit, tahun_terbit, harga, stok, category_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        $success = $stmt->execute([
            $judul,
            $penulis,
            $penerbit,
            $tahun_terbit,
            $harga,
            $stok,
            $category_id
        ]);

        if ($success) {
            // ✅ Redirect ke halaman daftar produk
            header("Location: ../../index.php?page=product/index");
            exit;
        } else {
            echo "❌ Gagal menyimpan data ke database.";
        }
    } catch (PDOException $e) {
        echo "⚠️ Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo "Akses tidak valid.";
}
