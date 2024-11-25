<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // セッションが開始されていない場合のみ開始
}

// ユーザーがログインしているかを確認
$isLoggedIn = isset($_SESSION['user_id']);

?>


<header>
    <nav>
        <ul>
            <li><a href="index.php">トップページ</a></li>
            <li><a href="characters.php">キャラクター</a></li>
            <li><a href="groups.php">グループ</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="php/logout.php">ログアウト</a></li>
                <li><span><?php echo htmlspecialchars($_SESSION['username']); ?> でログイン中</span></li>
            <?php else: ?>
                <li><a href="register.php">登録</a></li>
                <li><a href="login.php">ログイン</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>