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
    <script src="https://www.google.com/recaptcha/api.js?render=6LdneFwkAAAAAF-awKK13QDXVgog_mKGoPuJnJyR"></script>
    <script>
    grecaptcha.ready(function () {
        grecaptcha.execute("6LdneFwkAAAAAF-awKK13QDXVgog_mKGoPuJnJyR", {action: "sent"}).then(function(token) {
        var recaptchaResponse = document.getElementById("recaptchaResponse");
        recaptchaResponse.value = token;
        });
    });
    </script>
  </head>
  <body class="text-center">
    <h1>ログインページ</h1>
    <form action="login.php" method="post">
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
    <input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
    <input type="submit" value="ログイン">
    </form>
  </body>
</html>