<?php
require 'db.php'; // データベース接続

$request = json_decode(file_get_contents("php://input"), true);
$data = $request['data'] ?? [];

if (empty($data)) {
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $pdo->query("SELECT id, other_info FROM investigators");
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($characters as $character) {
    $otherInfo = json_decode($character['other_info'], true) ?? [];
    foreach ($data as $key => $values) {
        if (isset($otherInfo[$key])) {
            $otherInfo[$key] = $values[array_search($character['id'], array_keys($data[$key]))] ?? $otherInfo[$key];
        }
    }
    $stmtUpdate = $pdo->prepare("UPDATE investigators SET other_info = :other_info WHERE id = :id");
    $stmtUpdate->execute([
        ':other_info' => json_encode($otherInfo),
        ':id' => $character['id']
    ]);
}

echo json_encode(['success' => true]);
