<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

$divingNumber = $_POST['divingNumber'];
$date = $_POST['date'];
$location = $_POST['location'];
$diveSite = $_POST['diveSite'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];
$id = $_POST['id'];


//2. DB接続します
//*** function化する！  *****************
try {
    $db_name = 'gs_db'; //データベース名
    $db_id   = 'root'; //アカウント名
    $db_pw   = ''; //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
};

//３．データ登録SQL作成 すでにあるものの変更はUPDATE
// UPDATE テーブル明 SET カラム1 = 1に保存したいもの, カラム2 = 2に保存したいもの,,, WHERE条件 id = 送られてきたid
$stmt = $pdo->prepare('UPDATE gs_dive_table
 SET divingNumber = :divingNumber,
 date = :date,
 location = :location,
 diveSite = :diveSite,
 rating = :rating,
 comment = :comment
  WHERE id = :id;'
);

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':divingNumber', $divingNumber, PDO::PARAM_INT);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':location', $location, PDO::PARAM_STR);
$stmt->bindValue(':diveSite', $diveSite, PDO::PARAM_STR);
$stmt->bindValue(':rating', $rating, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

// 検証方法
// var_dump($status);
// exit();　　

//３．データ表示

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}


?>