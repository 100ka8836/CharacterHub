<?php
require 'db.php';

if (!isset($_GET['id'])) {
    die("キャラクターIDが指定されていません。");
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM investigators WHERE id = :id");
$stmt->execute([':id' => $id]);
$character = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$character) {
    die("キャラクターが見つかりませんでした。");
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($character['name']) ?>の詳細</title>
</head>

<body>
    <h1><?= htmlspecialchars($character['name']) ?>の詳細</h1>
    <p><strong>職業:</strong> <?= htmlspecialchars($character['occupation']) ?></p>
    <p><strong>出身地:</strong> <?= htmlspecialchars($character['birthplace']) ?></p>
    <p><strong>性別:</strong> <?= htmlspecialchars($character['sex']) ?></p>
    <p><strong>年齢:</strong> <?= htmlspecialchars($character['age']) ?></p>
    <p><strong>STR:</strong> <?= htmlspecialchars($character['str']) ?></p>
    <p><strong>CON:</strong> <?= htmlspecialchars($character['con']) ?></p>
    <p><strong>DEX:</strong> <?= htmlspecialchars($character['dex']) ?></p>
    <!-- 必要に応じて他のフィールドを追加 -->
</body>

</html>