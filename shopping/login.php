<?php
namespace portfolio;

session_start();

require_once dirname(__FILE__) . '/Bootstrap.class.php';

$db_host = 'localhost';
$db_name = 'portfolio_db';
$db_user = 'root';
$db_pass = 'root';
echo '<br>';
$msg = '';
$err_msg = '';
// データベースホストへ接続する
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
// var_dump($_POST);
echo '<br>';
if ($link !== false) {
    $query = "SELECT user_name, password FROM users ";
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
if (isset($_POST['login']) === true) {
  if (isset($_POST['user_name']) !== true || isset($_POST['password']) !== true) {
    $err_msg = '名前・パスワードが入力されていません。';
  } else {
    $name = $_POST['user_name'];
    $password = $_POST['password'];
  }
  if ($name == $data[0]['user_name'] && $password == $data[0]['password']) {
    $msg = 'ログインに成功しました';
    $_SESSION['user_name'] = $name;
    $_SESSION['password'] = $password;
    header("Location: list.php");
    exit;
  } else {
    $err_msg = '名前またはパスワードが間違っています';
  }
  // var_dump($name);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
  <div class="text-center">
    <form method="post" action="">
      <div class="py-3">
        お名前：<input type="text" name="user_name">
      </div>
      <div class="py-3">
        パスワード：<input type="password" name="password">
      </div>
      <div class="pt-3">
        <input class="btn btn-primary" type="submit" name="login" value="ログイン">
      </div>
    </form>
    <?php
    if ($msg     !== '') {
        echo '<p>' . $msg . '</p>';
    }
    if ($err_msg !== '') {
        echo '<p style="color:#f00;">' . $err_msg . '</p>';
    }
    ?>
    <div class='py-3'>
      <a href="#">パスワードをお忘れの方</a>
    </div>
    <div class=''>
      <a href="#">会員登録がお済みでない方はこちら</a>
    </div>
  </div>
</body>
