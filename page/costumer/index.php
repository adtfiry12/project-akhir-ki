<?php
include "system/connection.php";

try {
    $sql = "SELECT id, nama, no_telp, status_member, nomor_membership FROM customers";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customers</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include "page/template/navbar_admin.php"; ?>

    <div class="flex flex-1">
        <?php include "page/template/sidebar_admin.php"; ?>

        <main class="flex-1 p-6 overflow-hidden">
            <div class="bg-white shadow-md rounded p-6 flex flex-col h-full">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <h2 class="text-xl font-semibold text-orange-600">Daftar Customers</h2>
                    <a href="index.php?page=costumer/create"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 font-bold text-sm">
                        <i class="fa fa-plus mr-1"></i>Tambah
                    </a>
                </div>

                <!-- Scroll body only -->
                <div class="flex-1 overflow-auto border border-gray-300 rounded shadow-inner">
                    <table class="min-w-full text-sm text-left border-collapse table-fixed">
                        <thead class="bg-orange-800 text-white sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-2 w-12">No</th>
                                <th class="px-4 py-2 w-20">ID</th>
                                <th class="px-4 py-2 w-40">Nama</th>
                                <th class="px-4 py-2 w-32">No. Telp</th>
                                <th class="px-4 py-2 w-32">Status Member</th>
                                <th class="px-4 py-2 w-40">Nomor Membership</th>
                                <th class="px-4 py-2 w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($customers)): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($customers as $c): ?>
                                    <tr class="hover:bg-orange-50 even:bg-gray-50">
                                        <td class="px-4 py-2 border-t border-gray-300"><?= $no++ ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($c['id']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($c['nama']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($c['no_telp']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300">
                                            <?= $c['status_member'] == 1 ? "Membership" : "Non Membership" ?>
                                        </td>
                                        <td class="px-4 py-2 border-t border-gray-300"><?= htmlspecialchars($c['nomor_membership']) ?></td>
                                        <td class="px-4 py-2 border-t border-gray-300">
                                            <div class="flex justify-center gap-2 flex-wrap">
                                                <a href="index.php?page=costumer/edit&id=<?= $c['id'] ?>"
                                                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 font-bold text-xs md:text-sm whitespace-nowrap">
                                                    Edit
                                                </a>
                                                <a href="process/costumer/delete.php?id=<?= $c['id'] ?>"
                                                    onclick="return confirm('Anda yakin ingin menghapus customer ini?')"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 font-bold text-xs md:text-sm whitespace-nowrap">
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-orange-600">
                                        Tidak ada data
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