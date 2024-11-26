<?php
require 'db.php'; // データベース接続

// ソートパラメータを取得
$sortColumn = $_GET['sortColumn'] ?? 'id';
$sortOrder = $_GET['sortOrder'] ?? 'asc';

// データベースからすべてのキャラクター情報を取得（ソート）
$stmt = $pdo->prepare("SELECT * FROM investigators ORDER BY $sortColumn $sortOrder");
$stmt->execute();
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>キャラクター一覧</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/tab_navigation.js"></script>
    <script src="js/character_sort.js"></script>
</head>

<body>
    <?php if (empty($characters)): ?>
        <p>現在登録されたキャラクターはありません。</p>
    <?php else: ?>
        <!-- タブメニュー -->
        <div class="tabs">
            <button class="tab-button" onclick="showTab('tab-basic')">基本</button>
            <button class="tab-button" onclick="showTab('tab-attributes')">能力</button>
            <button class="tab-button" onclick="showTab('tab-skills')">技能</button>
        </div>

        <!-- 基本タブ -->
        <div id="tab-basic" class="tab-content">
            <table class="character-table">
                <thead>
                    <tr>
                        <th>名称</th>
                        <?php foreach ($characters as $character): ?>
                            <th><?= htmlspecialchars($character['name']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>年齢</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['age']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>性別</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['sex']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>HP</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['hp']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>MP</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['mp']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>DB</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['db']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>SAN</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['san_current']) ?>/<?= htmlspecialchars($character['san_max']) ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 能力タブ -->
        <div id="tab-attributes" class="tab-content" style="display: none;">
            <table class="character-table">
                <thead>
                    <tr>
                        <th>名称</th>
                        <?php foreach ($characters as $character): ?>
                            <th><?= htmlspecialchars($character['name']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>STR</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['str']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>CON</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['con']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>POW</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['pow']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>DEX</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['dex']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>APP</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['app']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>SIZ</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['siz']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>INT</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['int_value']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td>EDU</td>
                        <?php foreach ($characters as $character): ?>
                            <td><?= htmlspecialchars($character['edu']) ?></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 技能タブ -->
        <div id="tab-skills" class="tab-content" style="display: none;">
            <table class="character-table">
                <thead>
                    <tr>
                        <th>技能名</th>
                        <?php foreach ($characters as $character): ?>
                            <th><?= htmlspecialchars($character['name']) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // すべての技能をユニークに集める
                    $allSkills = [];
                    foreach ($characters as $character) {
                        $skills = json_decode($character['skills'], true);
                        if (is_array($skills)) {
                            foreach ($skills as $skill) {
                                $allSkills[$skill['name']] = $skill['name'];
                            }
                        }
                    }
                    // テーブル表示
                    foreach ($allSkills as $skillName): ?>
                        <tr>
                            <td><?= htmlspecialchars($skillName) ?></td>
                            <?php foreach ($characters as $character):
                                $skills = json_decode($character['skills'], true);
                                $skillValue = '-';
                                if (is_array($skills)) {
                                    foreach ($skills as $skill) {
                                        if ($skill['name'] === $skillName) {
                                            $skillValue = $skill['value'] ?? '-';
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <td><?= htmlspecialchars($skillValue) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>

</html>