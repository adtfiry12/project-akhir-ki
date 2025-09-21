<?php
session_start();
include "system/connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
$admin_id = $_SESSION['admin_id'];

try {
    $sql = "
    SELECT 
        op.quantity,
        op.total_harga,
        o.created_at,
        o.total_payment,
        o.total_items,
        a.email AS admin_email,
        u.nama AS user_nama,
        u.email AS user_email
    FROM order_products op
    JOIN orders o ON op.order_id = o.id
    JOIN admins a ON o.admin_id = a.id
    JOIN users u ON o.customer_id = u.id
    ORDER BY o.created_at DESC
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Order</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include "page/template/navbar_admin.php"; ?>

    <div class="flex flex-1">
        <?php include "page/template/sidebar_admin.php"; ?>

        <main class="flex-1 p-6 overflow-hidden">
            <h2 class="text-2xl font-bold text-orange-600 mb-4">Daftar Order</h2>

            <div class="bg-white shadow-md rounded p-4 w-full">
                <!-- Scroll body only -->
                <div class="overflow-auto max-h-[70vh] border border-gray-300 rounded">
                    <table class="min-w-full text-sm text-left border-collapse table-fixed">
                        <thead class="bg-orange-800 text-white sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-2 w-12">No</th>
                                <th class="px-4 py-2 w-20">Qty</th>
                                <th class="px-4 py-2 w-32">Total Harga</th>
                                <th class="px-4 py-2 w-40">Tanggal</th>
                                <th class="px-4 py-2 w-32">Total Payment</th>
                                <th class="px-4 py-2 w-28">Total Items</th>
                                <th class="px-4 py-2 w-48">Admin Email</th>
                                <th class="px-4 py-2 w-40">Nama User</th>
                                <th class="px-4 py-2 w-48">Email User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($orders as $o): ?>
                                    <tr class="hover:bg-gray-50 even:bg-gray-100">
                                        <td class="px-4 py-2 border-t border-gray-300"><?= $no++ ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['quantity']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= number_format($o['total_harga'], 2) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['created_at']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= number_format($o['total_payment'], 2) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['total_items']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['admin_email']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['user_nama']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($o['user_email']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-orange-600">
                                        Tidak ada data order
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>