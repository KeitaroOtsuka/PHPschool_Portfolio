<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\board\board3.php
 * ファイル名：board3.php
 * アクセスURL：http://localhost:8888/DT/board/board3.php
 *
 * 学習内容：データベース(MySQL/MariaDB)との接続
 */

session_start();

$db_host = 'localhost';
$db_name = 'shopping_db';
$db_user = 'root';
$db_pass = 'root';
var_dump($_POST);
echo '<br>';
$msg = '';
$err_msg = '';
// データベースホストへ接続する
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
// var_dump($link);
if ($link !== false) {
    $query = "SELECT name, password FROM user ";
    $res = mysqli_query($link, $query);
    // var_dump($res);
    $data = [];
    // 結果を配列に格納する
    while ($row = mysqli_fetch_assoc($res)) {
        // $lineArray3[] = $lineArray2;
        $data[] = $row;
        // array_push( $resArr, $row);
        // 下記は上記と同じ動作
    }
    // arsort(ｴｰｱｰﾙｿｰﾄ)：降順(逆順)で表示
} else {
    echo "データベースの接続に失敗しました";
}
// var_dump($data);
// データベースへの接続を閉じる
mysqli_close($link);
if (isset($_POST['send']) === true) {
  if (isset($_POST['name']) !== true || isset($_POST['password']) !== true) {
    $err_msg = '名前・パスワードが入力されていません。';
  } else {
    $name = $_POST['name'];
    $password = $_POST['password'];
  }
  if ($name == $data[0]['name'] && $password == $data[0]['password']) {
    $msg = 'ログインに成功しました';
    $_SESSION['user_name'] = $name;
    header("Location: list.php");
    exit;
  } else {
    $err_msg = '名前またはパスワードが間違っています';
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
	<form method="post" action="">
		名前 <input type="text" name="name" value=""> 
    パスワード<input type="text" name="password">
	<input type="submit" name="send" value="ログイン">
	</form>
  <?php 
    echo $msg;
    echo $err_msg;
  ?>
</body>
</html>