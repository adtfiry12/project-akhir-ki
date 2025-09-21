<?php
include "system/connection.php";

function generateMembershipNumber()
{
    return strtoupper(bin2hex(random_bytes(5)));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Customer</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<script>
    function toggleMembership() {
        const status = document.getElementById('status_member').value;
        const membershipInput = document.getElementById('nomor_membership');
        if (status === '1') {
            membershipInput.value = '<?= generateMembershipNumber(); ?>';
            membershipInput.readOnly = true;
        } else {
            membershipInput.value = '-';
            membershipInput.readOnly = true;
        }
    }
</script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include "page/template/navbar_admin.php"; ?>

    <div class="flex flex-1">
        <?php include "page/template/sidebar_admin.php"; ?>

        <main class="flex-1 p-6">
            <div class="bg-white shadow-md rounded p-6 max-w-lg mx-auto">
                <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Tambah Customer</h2>
                <form action="process/costumer/create.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="nama" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. Telp</label>
                        <input type="text" name="no_telp" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Member</label>
                        <select id="status_member" name="status_member" onchange="toggleMembership()" required
                            class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                            <option value="0">Non Membership</option>
                            <option value="1">Membership</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor Membership</label>
                        <input type="text" id="nomor_membership" name="nomor_membership" value="-" readonly
                            class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2">
                    </div>
                    <button type="submit"
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>