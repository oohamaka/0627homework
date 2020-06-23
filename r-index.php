<?php
ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'memo_review');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

//データベースへ接続
try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

//データベース登録用の関数の作成
function create($dbh, $title, $body) {
    $stmt = $dbh->prepare("INSERT INTO memos_review(title,body) VALUES(?,?)");
    $data = [];
    $data[] = $title;
    $data[] = $body;
    $stmt->execute($data);
}

//データベースからデータを取得する関数の作成
function selectAll($dbh){
    $stmt = $dbh->prepare('SELECT * FROM memos_review ORDER BY updated_at DESC');
    $stmt -> execute();
    return $stmt ->fetchAll(PDO::FETCH_ASSOC);  
}

//select * from memos where id = 1;

// create($dbh, "PHP", "PHPから登録します!");
$result = selectAll($dbh);

if (!empty($_POST)){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    create($dbh,$title,$body);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
 <?php foreach($result as $row): ?>
  <div><?php echo "title: " . $row["title"]; ?></div>
  <div><?php echo "body: " . $row["body"]; ?></div>
 <?php endforeach ?> 

<!--r-index.php（自分自身）にタイトル、日付、内容を送信-->

<form action="r-index.php" method="POST">
title:<input name="title" type="text"><br>
body:<br>
<textarea style="width:1200px; height:300px;" name="body"></textarea><br>
<input type="submit" value="送信">
</form>
</body>
</html>


