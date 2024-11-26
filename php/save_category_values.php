<?php
require 'db.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['character_id'], $input['category_id'], $input['field_value'])) {
    echo json_encode(['success' => false, 'message' => '必要なデータが不足しています。']);
    exit;
}

$characterId = (int) $input['character_id'];
$categoryId = (int) $input['category_id'];
$fieldValue = trim($input['field_value']);

try {
    $stmt = $pdo->prepare("
        INSERT INTO character_additional_info (character_id, category_id, field_value)
        VALUES (:character_id, :category_id, :field_value)
        ON DUPLICATE KEY UPDATE field_value = :field_value
    ");
    $stmt->execute([
        ':character_id' => $characterId,
        ':category_id' => $categoryId,
        ':field_value' => $fieldValue,
    ]);

    echo json_encode(['success' => true, 'message' => 'データが保存されました。']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $e->getMessage()]);
}
