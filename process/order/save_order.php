<?php
session_start();
include "../../system/connection.php";

$admin_id    = $_POST['admin_id'];
$kode_member = trim($_POST['kode_member'] ?? '');
$cart        = json_decode($_POST['cart'], true);
$diskon      = floatval($_POST['diskon'] ?? 0);

$user_id = $_SESSION['user_id'] ?? null;

$customer_id = $user_id;
if ($kode_member !== '') {
    $stmt = $db->prepare("SELECT id, status_member FROM customers WHERE nomor_membership = ?");
    $stmt->execute([$kode_member]);
    $cust = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($cust && (int)$cust['status_member'] === 1) {
        $customer_id = $cust['id'];
    }
}

$total_items   = 0;
$total_payment = 0;
foreach ($cart as $c) {
    $total_items  += (int)$c['qty'];
    $total_payment += $c['harga'] * (int)$c['qty'];
}
$total_payment -= $diskon;
$ppn = $total_payment * 0.11;
$total_payment += $ppn;

try {
    $db->beginTransaction();

    $stmt = $db->prepare("
        INSERT INTO orders (admin_id, customer_id, created_at, total_payment, total_items, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $admin_id,
        $customer_id,
        date('Y-m-d H:i:s'),
        $total_payment,
        $total_items,
        'pending'
    ]);
    $order_id = $db->lastInsertId();

    $stmtDetail = $db->prepare("
        INSERT INTO order_products (order_id, product_id, quantity, total_harga)
        VALUES (?, ?, ?, ?)
    ");
    $stmtStok = $db->prepare("
        UPDATE products SET stok = stok - ? WHERE id = ? AND stok >= ?
    ");

    foreach ($cart as $pid => $c) {
        $qty      = (int)$c['qty'];
        $subtotal = $c['harga'] * $qty;

        $stmtStok->execute([$qty, $pid, $qty]);
        if ($stmtStok->rowCount() === 0) {
            throw new Exception("Stok produk ID $pid tidak mencukupi");
        }

        $stmtDetail->execute([$order_id, $pid, $qty, $subtotal]);
    }

    $db->commit();
    echo "Order berhasil disimpan";
} catch (Exception $e) {
    $db->rollBack();
    echo "Gagal menyimpan order: " . $e->getMessage();
}
