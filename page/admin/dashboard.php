<?php
session_start();
include "system/connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=admin/login");
    exit;
}
$admin_id = $_SESSION['admin_id'];

// =====================
// QUERY & PERHITUNGAN
// =====================
try {
    $sql = "
        SELECT 
            op.quantity,
            o.total_payment
        FROM order_products op
        JOIN orders o ON op.order_id = o.id
    ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total_order       = count($data);  // jumlah baris order
    $total_barang      = 0;             // total semua quantity
    $total_all_payment = 0;             // total seluruh uang (total_payment)

    foreach ($data as $d) {
        $total_barang      += (int)$d['quantity'];
        $total_all_payment  += (float)$d['total_payment'];
    }
} catch (PDOException $e) {
    die("Query gagal: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <?php include "page/template/navbar_admin.php" ?>
    <div class="flex h-[81vh]">
        <?php include "page/template/sidebar_admin.php" ?>
        <main class="flex-1 p-6 flex flex-col items-center justify-center">
            <h1 class="text-2xl font-bold text-orange-600 mb-8 text-center">Dashboard Admin</h1>

            <!-- Kartu Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl">
                <!-- Total Order -->
                <div class="bg-white border border-gray-300 rounded-xl shadow p-6 flex flex-col items-center justify-center">
                    <i class="fa-solid fa-box-open text-orange-500 text-5xl mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Order</h2>
                    <p class="text-3xl font-bold text-orange-600"><?= $total_order ?></p>
                </div>

                <!-- Total Barang -->
                <div class="bg-white border border-gray-300 rounded-xl shadow p-6 flex flex-col items-center justify-center">
                    <i class="fa-solid fa-cart-shopping text-green-500 text-5xl mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Barang</h2>
                    <p class="text-3xl font-bold text-orange-600"><?= $total_barang ?></p>
                </div>

                <!-- Total Payment -->
                <div class="bg-white border border-gray-300 rounded-xl shadow p-6 flex flex-col items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-blue-500 text-5xl mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Total Seluruh Uang</h2>
                    <p class="text-3xl font-bold text-orange-600">
                        Rp <?= number_format($total_all_payment, 2) ?>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>

</html>