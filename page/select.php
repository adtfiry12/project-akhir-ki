<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-100">

    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md text-center">
            <h2 class="text-2xl font-bold mb-6 text-orange-500">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>Register
            </h2>

            <!-- User Login -->
            <a href="index.php?page=user/register"
                class="flex items-center justify-center w-full mb-4 px-4 py-3 bg-orange-500 hover:bg-orange-600 
                      text-white font-semibold rounded-lg transition">
                <i class="fa-solid fa-user mr-2"></i> User
            </a>

            <!-- Admin Login -->
            <a href="index.php?page=admin/login"
                class="flex items-center justify-center w-full px-4 py-3 bg-gray-700 hover:bg-gray-800 
                      text-white font-semibold rounded-lg transition">
                <i class="fa-solid fa-user-shield mr-2"></i> Admin
            </a>
        </div>
    </div>

</body>

</html>