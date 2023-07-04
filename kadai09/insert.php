<?php

//1. POSTデータ取得
$divingNumber = $_POST['divingNumber'];
$date = $_POST['date'];
$location = $_POST['location'];
$diveSite = $_POST['diveSite'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

// 2. 画像アップロード処理
$targetDir = "uploads/";
$fileName = basename($_FILES["photo"]["name"]);
$targetFile = $targetDir . $fileName;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
  echo "The file " . $fileName . " has been uploaded.";
} else {
  echo "File upload failed. " . $_FILES["photo"]["error"];
}


// 既存の同名ファイルがあるかチェック
if (file_exists($targetFile)) {
    echo "File already exists.";
    $uploadOk = 0;
}

// ファイルサイズ制限（10MB以下）
if ($_FILES["photo"]["size"] > 10 * 1024 * 1024) {
    echo "File size exceeds the limit (10MB).";
    $uploadOk = 0;
}

// 特定のファイル形式のみ受け入れる
$allowedExtensions = array("jpg", "jpeg", "png", "gif");
if (!in_array($imageFileType, $allowedExtensions)) {
    echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
    $uploadOk = 0;
}

// アップロードが許可されているかどうかをチェック
if ($uploadOk == 0) {
  echo "File upload failed. Invalid file.";
} else {
  // ...

  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
      echo "The file " . $fileName . " has been uploaded.";
  } else {
      echo "File upload failed. " . $_FILES["photo"]["error"];
  }
}


// 3. DB接続
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError:' . $e->getMessage());
}

// 4. データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_dive_table (id, divingNumber, date, location, diveSite, rating, comment, photo) VALUES (NULL, :divingNumber, :date, :location, :diveSite, :rating, :comment, :photo)");

$stmt->bindValue(':divingNumber', $divingNumber, PDO::PARAM_INT);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':location', $location, PDO::PARAM_STR);
$stmt->bindValue(':diveSite', $diveSite, PDO::PARAM_STR);
$stmt->bindValue(':rating', $rating, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':photo', $fileName, PDO::PARAM_STR);

$status = $stmt->execute();

if ($status === false) {
    $error = $stmt->errorInfo();
    echo "Database Error: " . $error[2];
    exit();
} else {
    // データベースへの挿入が成功した場合
    $lastInsertId = $pdo->lastInsertId();
    header('Location: select.php');
    exit();

    // 5. 挿入したデータを取得して表示
    $stmt = $pdo->prepare("SELECT * FROM gs_dive_table WHERE id = :id");
    $stmt->bindValue(':id', $lastInsertId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // データの表示
    echo "Diving Number: " . $result['divingNumber'] . "<br>";
    echo "Date: " . $result['date'] . "<br>";
    echo "Location: " . $result['location'] . "<br>";
    echo "Dive Site: " . $result['diveSite'] . "<br>";
    echo "Rating: " . $result['rating'] . "<br>";
    echo "Comment: " . $result['comment'] . "<br>";
    echo "Photo: <img src='uploads/" . $result['photo'] . "' alt='Dive Photo' width='200px'><br>";
}


// ...
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diving Log - Confirmation</title>
</head>

<body>
    <h1>Diving Log - Confirmation</h1>
    <div>
        <h2 a heref="select.php">Go to Diving Record</h2>
    </div>
</body>

</html>
