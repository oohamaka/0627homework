<!-- DB「memos_review」からファイル名、ボディを抽出、出力するファイル-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>保存したファイル一覧</title>
</head>
<body>
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

//データベースからデータを抽出
try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT id,title,body FROM memos_review WHERE 1';
    $stmt = $dbh -> prepare($sql);
    $stmt ->execute();

    $dbh = null;

echo 'ファイル一覧 <br /><br />';

while(true){
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false)
    {
    break;
    }
    echo $rec['title'];
    print'<br/>';
    echo $rec['body'];
    print'<br/>';

}
}
catch(Exception $e)
{
    print'ただいま障害によりご迷惑をおかけしております。';
    exit();
}


?>


<form method="POST" action="body.php">
<a href= "r-index.php?id=<?php echo $rec['title']; ?>"><?php echo $rec['title'] ?><br></a>

</form>
</body>
</html>