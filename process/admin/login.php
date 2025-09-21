<?php

session_start();
include "../../system/connection.php";

$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

$stmt = $db->prepare("SELECT id,email,password FROM admins WHERE email=?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($pass, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    header("location: ../../../../index.php?page=admin/dashboard");
    exit;
} else {
    $_SESSION['error'] = "Email atau Password salah";
    header("location: .../../../../index.php");
    exit;
}
