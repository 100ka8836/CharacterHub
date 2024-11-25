<?php
require 'header.php'; // ヘッダーを読み込む

if (session_status() === PHP_SESSION_NONE) {
  session_start(); // セッションが開始されていない場合のみ開始
}

// ユーザーがログインしているかを確認
$isLoggedIn = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>キャラクター管理 - CharacterHub</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
  <div class="container">
    <h2>キャラクター管理サイトへようこそ！</h2>
    <p>キャラクターシートをURLで登録</p>
    <p>ステータス比較や細かな情報の登録・閲覧に！</p>
  </div>
</body>

</html>