<?php

$id = $_GET['id'];

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
}

//３．データ登録SQL作成 すでにあるものの削除は　DELETE FROM
// DELETE テーブル名　WHERE  WHEREがないと全部削除されてしまうので注意！　　　  WHERE条件 id = 送られてきたid
$stmt = $pdo->prepare('DELETE FROM gs_dive_table WHERE id = :id'
);

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
