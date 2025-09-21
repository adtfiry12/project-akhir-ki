<?php
session_start();
include "../../system/connection.php";

$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

$stmt = $db->prepare("SELECT id, email, password FROM users WHERE email=?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($pass, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];      // session user_id
    $_SESSION['email']   = $user['email'];
    header("Location: ../../../../index.php?page=dashboard");
    exit;
} else {
    $_SESSION['error'] = "Email atau Password salah";
    header("Location: ../../../../index.php?page=login");
    exit;
}
