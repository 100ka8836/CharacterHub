<?php
require 'db.php';

header('Content-Type: application/json');

if (!isset($_GET['character_id'])) {
    echo json_encode(['success' => false, 'message' => 'キャラクターIDが必要です。']);
    exit;
}

$characterId = (int) $_GET['character_id'];

try {
    $stmt = $pdo->prepare("
        SELECT c.field_name, ai.field_value
        FROM character_additional_info ai
        JOIN categories c ON ai.category_id = c.id
        WHERE ai.character_id = :character_id
    ");
    $stmt->execute([':character_id' => $characterId]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $e->getMessage()]);
}
