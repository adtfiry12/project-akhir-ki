<?php
session_start();
include "system/connection.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID customer tidak ditemukan");
}

// Ambil data customer
$stmt = $db->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Customer tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <?php include "page/template/navbar_admin.php"; ?>
    <div class="flex h-[81vh]">
        <?php include "page/template/sidebar_admin.php"; ?>

        <div class="flex-1 p-6">
            <div class="max-w-lg bg-white p-6 rounded-xl shadow-md mx-auto mt-4">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Edit Customer</h2>

                <form action="process/costumer/update.php" method="POST" class="space-y-4">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($customer['id']) ?>">

                    <label class="block">
                        Nama:
                        <input type="text" name="nama" value="<?= htmlspecialchars($customer['nama']) ?>"
                            class="w-full border rounded px-3 py-2 mt-1" required>
                    </label>

                    <label class="block">
                        No. Telp:
                        <input type="text" name="no_telp" value="<?= htmlspecialchars($customer['no_telp']) ?>"
                            class="w-full border rounded px-3 py-2 mt-1" required>
                    </label>

                    <label class="block">
                        Status Member:
                        <select name="status_member" id="status_member" class="w-full border rounded px-3 py-2 mt-1">
                            <option value="0" <?= $customer['status_member'] == 0 ? 'selected' : '' ?>>Non Membership</option>
                            <option value="1" <?= $customer['status_member'] == 1 ? 'selected' : '' ?>>Membership</option>
                        </select>
                    </label>

                    <label class="block">
                        Nomor Membership:
                        <input type="text" name="nomor_membership" id="nomor_membership"
                            value="<?= htmlspecialchars($customer['nomor_membership']) ?>"
                            class="w-full border rounded px-3 py-2 mt-1" <?= $customer['status_member'] == 0 ? 'readonly' : '' ?>>
                    </label>

                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function generateMembershipNumber() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 10; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return result;
        }

        const statusSelect = document.getElementById('status_member');
        const nomorInput = document.getElementById('nomor_membership');

        statusSelect.addEventListener('change', () => {
            if (statusSelect.value == '1') { // jika Membership
                if (!nomorInput.value) {
                    nomorInput.value = generateMembershipNumber();
                }
                nomorInput.readOnly = false;
            } else {
                nomorInput.value = '';
                nomorInput.readOnly = true;
            }
        });
    </script>



</body>

</html>