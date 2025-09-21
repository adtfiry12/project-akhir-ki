<?php
include "../../system/connection.php";

$nomor = $_GET['nomor'] ?? '';

$stmt = $db->prepare("
    SELECT id, nama, status_member
    FROM customers
    WHERE nomor_membership = ?
    LIMIT 1
");
$stmt->execute([$nomor]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {
    echo json_encode([
        'id' => $data['id'],
        'nama' => $data['nama'],
        'status_member' => (int)$data['status_member']
    ]);
} else {
    echo json_encode(['status_member' => 0]);
}
