<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];

    // URLからIDを抽出（正規表現を利用）
    $matches = [];
    if (preg_match('/\/6th\/([A-Za-z0-9_-]+)\/?$/', $url, $matches)) {
        $id = $matches[1]; // 抽出されたID
    } else {
        echo "有効なキャラクターURLを入力してください。";
        exit;
    }

    // キャラエノAPIのエンドポイント
    $apiUrl = "https://charaeno.com/api/v1/6th/$id/summary";

    // キャラエノAPIからデータを取得
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    if ($data) {
        // データベース保存スクリプトに送信
        $postData = [
            'data' => json_encode($data + ['url' => $url]) // URLも追加
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/CharacterHub/php/save_investigator.php'); // 正しいURLに変更
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        echo $result; // 保存結果を表示
    } else {
        echo "キャラクター情報を取得できませんでした。";
    }
} else {
    echo "キャラクターURLを入力してください。";
}
?>