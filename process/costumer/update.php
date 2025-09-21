<?php
session_start();
include "../../system/connection.php";

if (!isset($_POST['id'])) {
    die("ID customer tidak ditemukan.");
}

$id = $_POST['id'];
$nama = trim($_POST['nama']);
$no_telp = trim($_POST['no_telp']);
$status_member = isset($_POST['status_member']) ? (int)$_POST['status_member'] : 0;
$nomor_membership = trim($_POST['nomor_membership']);

if ($nama === '' || $no_telp === '') {
    die("<script>alert('Nama dan No. Telp wajib diisi'); window.history.back();</script>");
}

if ($status_member === 1 && $nomor_membership === '') {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $nomor_membership = '';
    for ($i = 0; $i < 10; $i++) {
        $nomor_membership .= $chars[rand(0, strlen($chars) - 1)];
    }
}

if ($status_member === 0) {
    $nomor_membership = '';
}

try {
    $sql = "UPDATE customers 
            SET nama = ?, no_telp = ?, status_member = ?, nomor_membership = ?
            WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nama, $no_telp, $status_member, $nomor_membership, $id]);

    echo "<script>alert('Data berhasil diupdate'); window.location='../../index.php?page=costumer/index';</script>";
} catch (PDOException $e) {
    die("Gagal update: " . $e->getMessage());
}
