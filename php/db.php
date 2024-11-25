<?php
// データベース接続設定
$host = 'localhost';
$dbname = 'characterhub_db';
$username = 'root'; // ローカル環境では通常 "root"
$password = '100ka8836'; // XAMPPでは空、MAMPでは "root" に設定

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続失敗: " . $e->getMessage());
}
?>