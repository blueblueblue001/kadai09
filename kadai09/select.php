<?php

require_once('funcs.php');

try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DBConnectError' . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM gs_dive_table");
$status = $stmt->execute();

$view = "";
if ($status === false) {
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $view .= "<p>";
        $view .= '<a href="detail.php?id=' . $result['id'] . '">';

        $view .= h($result['divingNumber']) . ' :' . h($result['date']) . ' :' . h($result['location']) .' :' . h($result['diveSite']) .' <br>'
        . h($result['rating']) . ' <br>'
        . h($result['comment']) . '<br>'
        . '<img src="uploads/' . $result['photo'] . '" width="200px" height="auto">' . '</a>' . '<br>';

        //GETデータ送信リンク作成 削除　delete.phpへ遷移
        // <a>で囲う。
        $view .= '<a href="delete.php?id=' .$result['id'] .'">';
        $view .=' [Delete] ';
        $view .= '</a>';

        $view .= '</p>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diving Log - Records</title>
</head>

<body>
    <h1>Diving Log - Records</h1>
    <div>
        <?php echo $view; ?>
    </div>
</body>

</html>
