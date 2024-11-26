<?php
require 'db.php'; // データベース接続

header('Content-Type: application/json');

try {
    // カテゴリ一覧を取得
    $stmt = $pdo->prepare("
        SELECT id, field_name FROM categories
    ");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 各カテゴリに関連する値（キャラクターごとの値）を取得
    $valuesStmt = $pdo->prepare("
        SELECT c.id AS category_id, c.field_name, ci.character_id, ci.field_value
        FROM categories c
        LEFT JOIN character_additional_info ci ON c.id = ci.category_id
    ");
    $valuesStmt->execute();
    $values = $valuesStmt->fetchAll(PDO::FETCH_ASSOC);

    // カテゴリごとに値をまとめる
    $result = [];
    foreach ($categories as $category) {
        $result[] = [
            'id' => $category['id'],
            'field_name' => $category['field_name'],
            'values' => array_filter($values, function ($v) use ($category) {
                return $v['category_id'] === $category['id'];
            })
        ];
    }

    echo json_encode(['success' => true, 'fields' => $result]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $e->getMessage()]);
}
