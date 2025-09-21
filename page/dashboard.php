<?php
session_start();
include "process/category/select.php"; // ambil kategori & produk
include "system/connection.php";

// Redirect jika tidak login
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: index.php?page=login");
    exit;
}

$login_id = $_SESSION['user_id'] ?? $_SESSION['admin_id'];
$login_email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-gray-100">
    <?php include "page/template/navbar.php"; ?>
    <div class="flex h-[81vh]">
        <?php include "page/template/sidebar.php"; ?>

        <main class="flex-1 flex gap-6 p-6">

            <!-- Kiri: Produk & Kategori -->
            <div class="w-2/5 space-y-6">
                <div class="bg-white p-5 rounded-xl shadow-md">
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Kategori</h2>
                    <div class="flex flex-wrap gap-2">
                        <a href="index.php?page=dashboard"
                            class="px-3 py-1 rounded <?= (!isset($_GET['category'])) ? 'bg-orange-500 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">Semua</a>
                        <?php foreach ($categories as $cat): ?>
                            <a href="index.php?page=dashboard&category=<?= $cat['id'] ?>"
                                class="px-3 py-1 rounded <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'bg-orange-500 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
                                <?= htmlspecialchars($cat['nama_kategori']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Daftar Buku</h2>
                <div class="bg-white p-5 rounded-xl shadow-md space-y-3 overflow-y-scroll h-[58vh]">
                    <?php foreach ($products as $p): ?>
                        <div class="product border p-3 rounded-lg shadow-sm bg-gray-50 hover:bg-gray-100 cursor-pointer"
                            data-id="<?= $p['id'] ?>"
                            data-nama="<?= htmlspecialchars($p['judul']) ?>"
                            data-harga="<?= $p['harga'] ?>"
                            data-stok="<?= $p['stok'] ?>">
                            <div class="flex justify-between">
                                <span class="font-medium"><?= htmlspecialchars($p['judul']) ?></span>
                                <span class="text-orange-600 font-semibold">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                            </div>
                            <p class="text-sm text-gray-600">Penulis: <?= $p['penulis'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Kanan: Keranjang -->
            <div class="w-3/5 bg-white p-5 rounded-xl shadow-md h-[85vh]">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Keranjang</h2>
                <div class="overflow-x-auto overflow-y-scroll h-[25vh]">
                    <table id="cart-table" class="w-full border-collapse text-sm">
                        <thead class="bg-orange-500 text-white">
                            <tr>
                                <th class="p-2 text-left">Produk</th>
                                <th class="p-2">Harga</th>
                                <th class="p-2">Jumlah</th>
                                <th class="p-2">Subtotal</th>
                                <th class="p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <hr class="my-4">
                <p>Total: Rp <span id="total" class="text-orange-600 font-bold">0</span></p>
                <p class="mt-2">PPN (11%): Rp <span id="ppn">0</span></p>
                <p class="mt-2">Diskon: Rp <span id="diskon">0</span></p>
                <h3 class="text-xl font-bold mt-2">Grand Total: Rp <span id="grand_total" class="text-orange-600">0</span></h3>

                <div class="mt-4 space-y-2">
                    <label class="block">
                        Kode Anggota:
                        <input type="text" id="kode_member" class="border rounded px-3 py-1 w-full mt-1" placeholder="nomor membership">
                    </label>
                    <button onclick="cekMember()" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Cek</button>
                </div>

                <button onclick="checkout()" class="mt-6 w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Checkout</button>
            </div>
        </main>
    </div>

    <script>
        const LOGIN_ID = <?= json_encode($login_id) ?>;
    </script>
    <script src="system/order_js/script.js"></script>
</body>

</html>