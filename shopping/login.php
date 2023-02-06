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
}
// var_dump($msg);
?>

<h1><?php echo $msg; ?></h1>
<?php echo $link; ?>