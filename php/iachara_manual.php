<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $details = $_POST['details'];

    // データを保存する（仮：データベース接続）
    echo "<h1>キャラクター登録完了</h1>";
    echo "<p>名前: " . htmlspecialchars($name) . "</p>";
    echo "<p>カテゴリ: " . htmlspecialchars($category) . "</p>";
    echo "<p>詳細: " . htmlspecialchars($details) . "</p>";
}
?>