<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<head>
    <title>Login</title>
</head>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-orange-500">Login</h2>

        <?php if ($error): ?>
            <div class="mb-4 text-red-600 font-medium">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="process/user/login.php" method="post" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Masukkan email" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
                    placeholder="Masukkan password" required>
            </div>
            <div class="text-left mt-4 text-gray-700">
                <p>
                    Belum punya akun?
                    <a href="index.php?page=select"
                        class="text-orange-500 font-semibold hover:text-orange-600 transition">
                        Register
                    </a>
                </p>
            </div>
            <!-- Submit -->
            <div>
                <input type="submit" value="Login"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded-lg transition cursor-pointer">
            </div>
        </form>
    </div>
</div>