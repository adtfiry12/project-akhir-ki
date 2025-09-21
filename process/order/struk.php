<?php
session_start();
include "../../system/connection.php";

if (!isset($_GET['order_id'])) die("Order tidak ditemukan");
$order_id = (int)$_GET['order_id'];

// Ambil data order
$stmt = $db->prepare("
SELECT o.id,o.created_at,o.total_payment,o.total_items,o.diskon,o.ppn,
       u.nama AS user_nama,u.email AS user_email
FROM orders o
JOIN users u ON o.customer_id=u.id
WHERE o.id=:order_id
");
$stmt->execute(['order_id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

// Ambil item order
$stmt2 = $db->prepare("
SELECT p.judul,op.quantity,op.total_harga
FROM order_products op
JOIN products p ON op.product_id=p.id
WHERE op.order_id=:order_id
");
$stmt2->execute(['order_id' => $order_id]);
$items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Order #<?= $order_id ?></title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 3px;
            text-align: left;
        }

        hr {
            border: 1px dashed #000;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">STRUK PEMBELIAN</h2>
    <p>Order ID: <?= $order['id'] ?></p>
    <p>Tanggal: <?= $order['created_at'] ?></p>
    <p>Customer: <?= htmlspecialchars($order['user_nama']) ?></p>
    <hr>
    <table>
        <?php foreach ($items as $it): ?>
            <tr>
                <td><?= htmlspecialchars($it['judul']) ?> x<?= $it['quantity'] ?></td>
                <td style="text-align:right;">Rp <?= number_format($it['total_harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td class="total">PPN (11%)</td>
            <td style="text-align:right;">Rp <?= number_format($order['ppn'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td class="total">Diskon</td>
            <td style="text-align:right;">Rp <?= number_format($order['diskon'], 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td class="total">Grand Total</td>
            <td style="text-align:right;">Rp <?= number_format($order['total_payment'], 0, ',', '.') ?></td>
        </tr>
    </table>
    <hr>
    <p style="text-align:center;">Terima kasih telah berbelanja!</p>
    <script>
        window.print();
    </script>
</body>

</html>