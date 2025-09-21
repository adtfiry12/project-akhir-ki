<?php
include "../../system/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama             = trim($_POST['nama']);
    $no_telp          = trim($_POST['no_telp']);
    $status_member    = (int)$_POST['status_member'];
    $nomor_membership = trim($_POST['nomor_membership']);

    if ($nama === "" || $no_telp === "") {
        die("<script>alert('Semua field wajib diisi!'); window.history.back();</script>");
    }

    // Jika Non Membership, paksa nomor_membership menjadi NULL
    if ($status_member === 0) {
        $nomor_membership = null;
    }

    try {
        $sql = "INSERT INTO customers (nama, no_telp, status_member, nomor_membership)
                VALUES (:nama, :no_telp, :status_member, :nomor_membership)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':no_telp', $no_telp);
        $stmt->bindParam(':status_member', $status_member, PDO::PARAM_INT);
        $stmt->bindParam(':nomor_membership', $nomor_membership);
        $stmt->execute();

        header("Location: ../../index.php?page=costumer/index");
        exit;
    } catch (PDOException $e) {
        die("Gagal menambah data: " . $e->getMessage());
    }
}
