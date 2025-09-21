<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Category</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include "page/template/navbar_admin.php" ?>
    <div class="flex flex-1">
        <?php include "page/template/sidebar_admin.php" ?>
        <main class="flex-1 p-6 overflow-y-auto">
            <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md mx-auto">
                <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Tambah Category</h2>
                <form action="process/category/create.php" method="POST" class="space-y-4">
                    <div>
                        <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md 
                               focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400"
                            required>
                    </div>
                    <div class="flex justify-between pt-4">
                        <a href="index.php?page=product/index"
                            class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500 transition">Batal</a>
                        <button type="submit" name="submit"
                            class="bg-orange-500 text-white px-4 py-2 rounded-md font-bold hover:bg-orange-600 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>

</html>