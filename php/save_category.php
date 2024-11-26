<?php
require 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['field_name']) || empty($input['field_name'])) {
    echo json_encode(['success' => false, 'message' => 'カテゴリ名が無効です。']);
    exit;
}

$fieldName = trim($input['field_name']);

try {
    $stmt = $pdo->prepare("INSERT INTO categories (field_name) VALUES (:field_name)");
    $stmt->execute([':field_name' => $fieldName]);

    $categoryId = $pdo->lastInsertId();
    echo json_encode(['success' => true, 'category_id' => $categoryId]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $e->getMessage()]);
}
