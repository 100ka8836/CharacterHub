<?php
require 'db.php'; // データベース接続を読み込み

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // パスワードのハッシュ化
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // データベースにユーザーを挿入
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    try {
        $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
        echo "登録が成功しました！ログインページに戻る: <a href='../login.php'>ログイン</a>";
    } catch (PDOException $e) {
        echo "エラー: ユーザー名が既に使用されています。";
    }
}
?>