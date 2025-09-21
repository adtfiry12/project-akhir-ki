<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<!-- ✅ Tinggi penuh layar -->

<body class="bg-gray-100 h-screen flex flex-col">

    <!-- ===== NAVBAR (tinggi tetap) ===== -->
    <?php include "page/template/navbar_admin.php" ?>

    <!-- ===== MAIN AREA (sidebar + konten) ===== -->
    <div class="flex flex-1 h-0">
        <!-- Sidebar kiri (tinggi penuh sisa layar) -->
        <aside class="w-64 bg-white shadow-md h-full overflow-y-auto">
            <?php include "page/template/sidebar_admin.php" ?>
        </aside>

        <!-- Konten kanan (tinggi penuh sisa layar, scroll kalau form panjang) -->
        <main class="flex-1 bg-gray-50 p-6 overflow-y-auto">
            <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Tambah Buku</h2>

                <form action="process/product/create.php" method="POST" class="space-y-4">
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="judul"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                        <input type="text" name="penulis" id="penulis"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="penerbit" class="block text-sm font-medium text-gray-700">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                        <input type="number" name="harga" id="harga"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori ID</label>
                        <input type="number" name="category_id" id="category_id"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="index.php?page=product/index"
                            class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition">Batal</a>
                        <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-md font-bold hover:bg-green-600 transition">
                            Tambah
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>