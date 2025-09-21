<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <?php

    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        if ($page) {
            include "page/$page.php";
        } else {
            echo "halaman tidak ditemukan";
        }
    } else {
        include "page/login.php";
    }

    ?>
</body>

</html>