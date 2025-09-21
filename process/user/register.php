<?php
session_start();
require '../../system/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    // validasi sederhana
    if ($password !== $password2) {
        $_SESSION['error'] = "Password dan konfirmasi tidak sama.";
        header("Location: ../../index.php?page=user/register");
        exit;
    }

    // cek email sudah terdaftar
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
        header("Location: ../../index.php?page=user/register");
        exit;
    }

    // hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // insert data
    $stmt = $db->prepare("INSERT INTO users (nama, email, password) VALUES (:nama, :email, :password)");
    $stmt->bindValue(':nama', $nama);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);

    if ($stmt->execute()) {
        echo "<script>
        alert('Registrasi berhasil. Silakan login.');
        window.location.href='../../../../index.php';
    </script>";
        exit;
    } else {
        echo "<script>
        alert('Terjadi kesalahan, silakan coba lagi.');
        window.location.href='../../../../index.php?page=user/register';
    </script>";
        exit;
    }
}
