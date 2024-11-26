<?php
require 'db.php'; // データベース接続ファイルを読み込む

header('Content-Type: application/json');

// リクエストデータを受け取る
$input = json_decode(file_get_contents('php://input'), true);

// 必要なキーが存在するか確認
if (!isset($input['action']) || $input['action'] !== 'add_category') {
    echo json_encode(['success' => false, 'message' => 'アクションが不正です。']);
    exit;
}

if (!isset($input['field_name']) || empty($input['field_name'])) {
    echo json_encode(['success' => false, 'message' => 'カテゴリ名が無効です。']);
    exit;
}

$fieldName = $input['field_name'];

try {
    // カテゴリをデータベースに保存
    $stmt = $pdo->prepare("INSERT INTO character_additional_info (field_name) VALUES (:field_name)");
    $stmt->execute([':field_name' => $fieldName]);

    echo json_encode(['success' => true, 'message' => 'カテゴリが正常に追加されました。']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'データベースエラー: ' . $e->getMessage()]);
}

if ($input['action'] === 'add_category') {
    $fieldName = $input['field_name'];
    $stmt = $pdo->prepare("INSERT INTO categories (field_name) VALUES (:field_name)");
    $stmt->execute([':field_name' => $fieldName]);
    echo json_encode(['success' => true, 'message' => 'カテゴリが追加されました！']);
}
