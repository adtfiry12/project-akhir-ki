<?php
include "process/category/select_admin.php";
$currentCategory = isset($_GET['category']) ? $_GET['category'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- ===== NAVBAR ===== -->
    <?php include "page/template/navbar_admin.php" ?>

    <div class="flex flex-1 flex-col md:flex-row">
        <!-- ===== SIDEBAR KIRI ===== -->
        <?php include "page/template/sidebar_admin.php" ?>

        <!-- ===== KONTEN ===== -->
        <div class="flex-grow p-6 flex flex-col md:flex-row-reverse gap-6 md:h-[91vh]">

            <!-- ===== KATEGORI (KANAN) ===== -->
            <div class="w-full md:w-1/4 bg-white shadow-md rounded p-4 flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-orange-600">Kategori</h2>
                    <a href="index.php?page=category/create" class="text-orange-700 hover:text-gray-700 transition">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                </div>

                <!-- scroll vertikal kategori -->
                <div class="flex-1 overflow-y-auto max-h-[70vh] space-y-3 pr-1">
                    <?php $allActive = $currentCategory === ''; ?>
                    <a href="index.php?page=product/index"
                        class="block px-3 py-2 rounded text-center font-medium
                              <?= $allActive ? 'bg-orange-500 text-white shadow-md' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' ?>">
                        Semua
                    </a>
                    <?php foreach ($categories as $cat): ?>
                        <?php $isActive = ($currentCategory === (string)$cat['id']); ?>
                        <a href="index.php?page=product/index&category=<?= $cat['id'] ?>"
                            class="block px-3 py-2 rounded text-center font-medium
                                  <?= $isActive ? 'bg-orange-500 text-white shadow-md' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' ?>">
                            <?= htmlspecialchars($cat['nama_kategori']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ===== TABEL PRODUK (KIRI) ===== -->
            <div class="w-full md:w-3/4 bg-white shadow-md rounded p-4 flex flex-col">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <h2 class="text-xl font-semibold text-orange-600">Daftar Produk</h2>
                    <a href="index.php?page=product/create"
                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 font-bold text-sm">
                        Tambah
                    </a>
                </div>

                <!-- scroll vertikal & horizontal tabel -->
                <div class="flex-1 overflow-y-auto overflow-x-auto max-h-[70vh] border border-gray-300 rounded shadow-inner">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-orange-800 text-white sticky top-0">
                            <tr>
                                <th class="px-4 py-2">No</th>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Judul</th>
                                <th class="px-4 py-2">Penulis</th>
                                <th class="px-4 py-2">Penerbit</th>
                                <th class="px-4 py-2">Tahun Terbit</th>
                                <th class="px-4 py-2">Harga</th>
                                <th class="px-4 py-2">Stok</th>
                                <!-- ✅ min-w agar tombol tidak tumpuk -->
                                <th class="px-4 py-2 min-w-[140px] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($products) > 0):
                                $no = 1;
                            ?>
                                <?php foreach ($products as $p): ?>
                                    <tr class="hover:bg-orange-50 even:bg-gray-50">
                                        <td class="px-4 py-2 border-t border-gray-300"><?= $no++ ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['id']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['judul']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['penulis']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['penerbit']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['tahun_terbit']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars(number_format($p['harga'], 2)) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($p['stok']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300">
                                            <!-- ✅ flex + gap agar tombol sejajar dan ada jarak -->
                                            <div class="flex justify-center gap-2 flex-wrap">
                                                <a href="index.php?page=product/edit&id=<?= $p['id'] ?>"
                                                    class="bg-blue-500 text-white min-w-[70px] text-center px-3 py-1 rounded hover:bg-blue-600 font-bold text-xs md:text-sm whitespace-nowrap">
                                                    Edit
                                                </a>
                                                <a href="process/product/delete.php?id=<?= $p['id'] ?>" onclick="return confirm('Anda yakin ingin menghapus?')"
                                                    class="bg-red-500 text-white min-w-[70px] text-center px-3 py-1 rounded hover:bg-red-600 font-bold text-xs md:text-sm whitespace-nowrap">
                                                    Hapus
                                                </a>
                                            </div>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-orange-600">Tidak ada produk</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>

</html>