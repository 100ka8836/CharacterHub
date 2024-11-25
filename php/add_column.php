<?php
require 'db.php'; // データベース接続

$request = json_decode(file_get_contents("php://input"), true);
$columnName = $request['column_name'] ?? '';

if (!$columnName) {
    echo json_encode(['success' => false]);
    exit;
}

// 各キャラクターのother_infoに新しいカラムを追加
$stmt = $pdo->query("SELECT id, other_info FROM investigators");
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($characters as $character) {
    $otherInfo = json_decode($character['other_info'], true) ?? [];
    $otherInfo[$columnName] = "";
    $stmtUpdate = $pdo->prepare("UPDATE investigators SET other_info = :other_info WHERE id = :id");
    $stmtUpdate->execute([
        ':other_info' => json_encode($otherInfo),
        ':id' => $character['id']
    ]);
}

echo json_encode(['success' => true, 'column_name' => htmlspecialchars($columnName)]);
