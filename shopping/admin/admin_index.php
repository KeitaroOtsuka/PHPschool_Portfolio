<?php
namespace shopping\admin;

require_once '/Applications/MAMP/htdocs/Portfolio/shopping/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  </head>
  <body>
    <h1>管理者ホーム</h1>
    <a href="{{constant('shopping\\Bootstrap::ADMIN_URL')}}admin_logout.php" class="btn btn-danger">ログアウト</a>
    <br>
    <br>
    <a href="admin_user_index.php">
      ユーザー一覧
    </a>
    <br>
    <a href="admin_item_index.php">
      商品一覧
    </a>
  </body>
</html>