<?php
require 'header.php'; // ヘッダーを読み込む
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>キャラクター登録 - CharacterHub</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>

</head>

<body>
    <div class="container">
        <label for="siteSelect">登録するサイトを選択してください：</label>
        <select id="siteSelect" onchange="handleSiteChange()">
            <option value="">-- サイトを選択 --</option>
            <option value="charaeno">Charaeno（キャラエノ）</option>
            <option value="charasheet">キャラクター保管所</option>
            <option value="iachara">いあきゃら</option>
        </select>

        <!-- キャラエノフォーム -->
        <form id="charaenoForm" style="display: none;"
            onsubmit="submitForm(event, 'charaenoForm', 'php/charaeno_api.php')">
            <label for="charaenoUrl">キャラエノのキャラクターURL：</label>
            <input type="url" id="charaenoUrl" name="url" required>
            <button type="submit">登録</button>
        </form>

        <!-- キャラクター保管所フォーム -->
        <form id="charasheetForm" style="display: none;"
            onsubmit="submitForm(event, 'charasheetForm', 'php/charasheet_api.php')">
            <label for="charasheetUrl">キャラクター保管所のキャラクターURL：</label>
            <input type="url" id="charasheetUrl" name="url" required>
            <button type="submit">登録</button>
        </form>

        <!-- いあきゃらフォーム -->
        <form id="iacharaForm" style="display: none;"
            onsubmit="submitForm(event, 'iacharaForm', 'php/iachara_manual.php')">
            <label for="iacharaName">キャラクター名：</label>
            <input type="text" id="iacharaName" name="name" required>
            <label for="iacharaCategory">カテゴリ：</label>
            <input type="text" id="iacharaCategory" name="category">
            <label for="iacharaDetails">詳細：</label>
            <textarea id="iacharaDetails" name="details"></textarea>
            <button type="submit">登録</button>
        </form>

        <!-- メッセージ表示エリア -->
        <div id="message" style="margin-top: 20px; font-weight: bold;"></div>
    </div>

    <!-- キャラクター一覧のコンテナ -->
    <div id="character-list-container">
        <?php include 'php/characters_list.php'; ?>
    </div>
</body>

</html>