<?php
session_start();
require 'db.php'; // データベース接続

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ユーザー名でデータを取得
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // セッションにログイン情報を保存
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // デバッグ用メッセージ
        echo "ログイン成功！セッション設定中...";
        header("Location: ../index.php"); // トップページにリダイレクト
        exit;
    } else {
        echo "ユーザー名またはパスワードが間違っています。";
    }
}
?>