<?php
    namespace shopping;
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  </head>
  <body class="text-center">
    <h1>新規会員登録</h1>
    <form action="register.php" method="post">
    <div>
        <label>
            名前：
            <input type="text" name="name" required>
        </label>
    </div>
    <div>
        <label>
            メールアドレス：
            <input type="text" name="mail" required>
        </label>
    </div>
    <div>
        <label>
            パスワード：
            <input type="password" name="pass" required>
        </label>
    </div>
    <input class="btn btn-primary" type="submit" value="新規登録">
    </form>
    <p>すでに登録済みの方は<a href="login_form.php">こちら</a></p>
  </body>
</html>
