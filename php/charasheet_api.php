<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];

    // キャラクター保管所APIのエンドポイント（仮のURLを使用）
    $apiUrl = "https://charasheet.vampire-blood.net/api/v1/characters?url=" . urlencode($url);

    // APIリクエストを送信
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data) {
        echo "<h1>キャラクター情報</h1>";
        echo "<p>名前: " . htmlspecialchars($data['name']) . "</p>";
        echo "<p>カテゴリ: " . htmlspecialchars($data['category']) . "</p>";
        echo "<p>詳細: " . htmlspecialchars($data['details']) . "</p>";
    } else {
        echo "キャラクター保管所からデータを取得できませんでした。";
    }
}
?>