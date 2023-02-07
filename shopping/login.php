<?php
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;
use shopping\lib\Item;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$itm = new Item($db);

$msg = '';
$link = '';
if (isset($_POST['mail']) === true && isset($_POST['pass']) === true)
{
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    list($msg, $link) = $db->checkLogin($mail,$pass);
    // reCAPTCHA v3にてBOT判定
    if (isset($_POST["recaptchaResponse"]) && !empty($_POST["recaptchaResponse"])) {
        $secret = "6LdneFwkAAAAAHLz-zmbY2p6ePLntLkoKySLM1Ei";
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST["recaptchaResponse"]);
        $reCAPTCHA = json_decode($verifyResponse);
        if ($reCAPTCHA->success) {
            echo "認証成功";
        } else {
            echo "認証エラー";
        }
    } else {
        echo "不正アクセス";
    }    
}
// var_dump($msg);
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>