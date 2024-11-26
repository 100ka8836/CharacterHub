<?php
require 'db.php'; // データベース接続ファイル

// エラー表示を有効化（デバッグ用）
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);

    // データベースに保存するためのSQL
    $stmtInsert = $pdo->prepare("
        INSERT INTO investigators (
            url, name, occupation, birthplace, degree, mental_disorder, age, sex, 
            str, con, pow, dex, app, siz, int_value, edu, 
            hp, mp, db, san_current, san_max, luck, 
            skills, weapons, possessions, 
            personal_data, credit, 
            mythos_tomes, artifacts_and_spells, encounters, note, chatpalette, portrait_url
        ) VALUES (
            :url, :name, :occupation, :birthplace, :degree, :mental_disorder, :age, :sex, 
            :str, :con, :pow, :dex, :app, :siz, :int_value, :edu, 
            :hp, :mp, :db, :san_current, :san_max, :luck, 
            :skills, :weapons, :possessions, 
            :personal_data, :credit, 
            :mythos_tomes, :artifacts_and_spells, :encounters, :note, :chatpalette, :portrait_url
        )
    ");

    try {
        // データベースへの挿入を試みる
        $stmtInsert->execute([
            ':url' => $data['url'],
            ':name' => $data['name'],
            ':occupation' => $data['occupation'],
            ':birthplace' => $data['birthplace'],
            ':degree' => $data['degree'],
            ':mental_disorder' => $data['mentalDisorder'],
            ':age' => $data['age'],
            ':sex' => $data['sex'],
            ':str' => $data['characteristics']['str'],
            ':con' => $data['characteristics']['con'],
            ':pow' => $data['characteristics']['pow'],
            ':dex' => $data['characteristics']['dex'],
            ':app' => $data['characteristics']['app'],
            ':siz' => $data['characteristics']['siz'],
            ':int_value' => $data['characteristics']['int'],
            ':edu' => $data['characteristics']['edu'],
            ':hp' => $data['attribute']['hp'],
            ':mp' => $data['attribute']['mp'],
            ':db' => $data['attribute']['db'],
            ':san_current' => $data['attribute']['san']['value'],
            ':san_max' => $data['attribute']['san']['max'],
            ':luck' => $data['attribute']['luck'],
            ':skills' => json_encode($data['skills']),
            ':weapons' => json_encode($data['weapons']),
            ':possessions' => json_encode($data['possessions']),
            ':personal_data' => json_encode($data['personalData']),
            ':credit' => json_encode($data['credit']),
            ':mythos_tomes' => $data['mythosTomes'],
            ':artifacts_and_spells' => $data['artifactsAndSpells'],
            ':encounters' => $data['encounters'],
            ':note' => $data['note'],
            ':chatpalette' => $data['chatpalette'],
            ':portrait_url' => $data['portraitURL'] ?? null
        ]);

        // 成功メッセージを表示
        echo json_encode(['success' => true, 'message' => 'キャラクター情報を保存しました！'], JSON_UNESCAPED_UNICODE);

    } catch (PDOException $e) {
        // エラーメッセージを表示
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => '無効なリクエストです。']);
}
?>