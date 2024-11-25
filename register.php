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
  <title>ユーザー登録 - CharacterHub</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>

<body>
  <div class="container">
    <h1>ユーザー登録</h1>
    <form action="php/process_register.php" method="POST">
      <label for="username">ユーザー名</label>
      <input type="text" id="username" name="username" required />

      <label for="password">パスワード</label>
      <input type="password" id="password" name="password" required />

      <button type="submit">登録</button>
    </form>
    <p>
      既にアカウントをお持ちの方は
      <a href="login.php">こちら</a> からログインしてください。
    </p>
  </div>
</body>

</html>