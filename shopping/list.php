<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\shopping\list.php
 * ファイル名：list.php (商品一覧を表示するプログラム、Controller)
 * アクセスURL：http://localhost:8888/DT/shopping/list.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;
use shopping\lib\Item;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$itm = new Item($db);

// var_dump(__FILE__);
// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);

// SessionKeyを見て、DBへの登録状態をチェックする
// $ses->checkSession();
if (isset($_SESSION['name']))
{
      $username = $_SESSION['name'];
}
if (isset($_SESSION['id'])) {//ログインしているとき
    $msg = 'こんにちは' . htmlspecialchars($username, \ENT_QUOTES, 'UTF-8') . 'さん';
    $link = '<a href="logout.php">ログアウト</a>';
} else {//ログインしていない時
    $msg = 'ログインしていません';
    $link = '<a href="login_form.php">ログイン</a>';
    exit;
}
$link2 = '<a href="item_regist.php">商品登録</a>';
?>
<h1><?php echo $msg; ?></h1>
<?php echo $link; 
$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';
// var_dump($_SESSION);
// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();
// var_dump($cateArr);
// 商品リストを取得する
$dataArr = $itm->getItemList($ctg_id);
$context = [];
$context['msg'] = $msg;
$context['link'] = $link;
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);
?>
<h1><?php echo $link2; ?></h1>