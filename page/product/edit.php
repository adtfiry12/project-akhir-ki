<?php
include "system/connection.php";

// Pastikan ada parameter id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID buku tidak ditemukan!");
}

$id = (int) $_GET['id'];

// Ambil data buku berdasarkan id
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Data buku tidak ditemukan!");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <?php include "page/template/navbar_admin.php" ?>

    <div class="flex flex-1 h-0">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md h-full overflow-y-auto">
            <?php include "page/template/sidebar_admin.php" ?>
        </aside>

        <!-- Konten -->
        <main class="flex-1 bg-gray-50 p-6 overflow-y-auto">
            <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Edit Buku</h2>

                <form action="process/product/update.php" method="POST" class="space-y-4">
                    <!-- Hidden input untuk id -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="judul"
                            value="<?= htmlspecialchars($product['judul']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                        <input type="text" name="penulis" id="penulis"
                            value="<?= htmlspecialchars($product['penulis']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit"
                            value="<?= htmlspecialchars($product['penerbit']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit"
                            value="<?= htmlspecialchars($product['tahun_terbit']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="harga" id="harga"
                            value="<?= htmlspecialchars($product['harga']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok"
                            value="<?= htmlspecialchars($product['stok']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori ID</label>
                        <input type="number" name="category_id" id="category_id"
                            value="<?= htmlspecialchars($product['category_id']) ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="index.php?page=product/index"
                            class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition">Batal</a>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md font-bold hover:bg-blue-600 transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>