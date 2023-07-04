<?php

/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */

require_once('funcs.php');
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

//３．データ登録SQL作成
$stmt = $pdo->prepare('SELECT* FROM gs_dive_table WHERE id = :id;'
);

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

// 検証方法
// var_dump($status);
// exit();　　

//３．データ表示
$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $result = $stmt->fetch();
}

// 検証
// var_dump($result);

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
(入力項目は「登録/更新」はほぼ同じになるから)
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->


<!DOCTYPE html>
<html>
  <head>
    <title>Diving Map</title>
    <style>
      #map {
        height: 400px;
        width: 100%;
      }
    </style>
  </head>
  <body>
    <h1>Diving Log</h1>
    <div id="map"></div>
    <form id="logForm" method="POST" action="update.php">

      <label for="divingNumber">Dive No.:</label>
      <input type="number" id="divingNumber" name="divingNumber" value="<?= $result['divingNumber']?>"><br>
      <label for="date">Date:</label>
      <input type="date" id="date" name="date" value="<?= $result['date']?>"><br>
      <label for="location">Location:</label>
      <input type="text" id="location" name="location" value="<?= $result['location']?>"><br> 
      <label for="diveSite">Dive Site:</label>
      <input type="text" id="diveSite" name="diveSite" value="<?= $result['diveSite']?>"><br>
      <label for="rating">Rating:</label>
      <select id="rating" name="rating" value="<?= $result['rating']?>">
        <option value="⭐️">⭐️</option>
        <option value="⭐️⭐️">⭐️⭐️</option>
        <option value="⭐️⭐️⭐️">⭐️⭐️⭐️</option>
        <option value="⭐️⭐️⭐️⭐️">⭐️⭐️⭐️⭐️</option>
        <option value="⭐️⭐️⭐️⭐️⭐️">⭐️⭐️⭐️⭐️⭐️</option> 
      </select><br> 
      <label for="comment">Comment:</label>
      <textarea id="comment" name="comment"><?= $result['comment']?></textarea></label><br> 
      <!-- <label for="photo">Photo:</label> 
      <input type="file" id="photo" name="photo"><br> -->
      <input type="hidden" name="id" value="<?= $result['id']?>">

      <input type="submit" value="Update a Log">
    </form>

    <div class="navbar-header"><a class="navbar-brand" href="select.php">Dive Log Lists</a></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEa1T_F6ngy7gP9_nrXXTSZmVfqsYon3M&callback=initMap" async defer></script>
    <script src="js/script.js"></script>
    
  </body>
</html>