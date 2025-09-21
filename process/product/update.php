<?php
include "../../system/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form edit
    $id           = (int)$_POST['id'];
    $judul        = trim($_POST['judul']);
    $penulis      = trim($_POST['penulis']);
    $penerbit     = trim($_POST['penerbit']);
    $tahun_terbit = (int)$_POST['tahun_terbit'];
    $harga        = (int)$_POST['harga'];
    $stok         = (int)$_POST['stok'];
    $category_id  = (int)$_POST['category_id'];

    try {
        // Query update data
        $sql = "UPDATE products 
                SET judul = ?, 
                    penulis = ?, 
                    penerbit = ?, 
                    tahun_terbit = ?, 
                    harga = ?, 
                    stok = ?, 
                    category_id = ?
                WHERE id = ?";
        $stmt = $db->prepare($sql);

        $success = $stmt->execute([
            $judul,
            $penulis,
            $penerbit,
            $tahun_terbit,
            $harga,
            $stok,
            $category_id,
            $id
        ]);

        if ($success) {
            header("Location: ../../index.php?page=product/index");
            exit;
        } else {
            echo " Gagal mengupdate data produk.";
        }
    } catch (PDOException $e) {
        echo " Terjadi kesalahan: " . $e->getMessage();
    }
} else {
    echo " Akses tidak valid.";
}
