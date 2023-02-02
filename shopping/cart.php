<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\shopping\cart.php
 * ファイル名：cart.php (カートページの処理を制御するコントローラー)
 * アクセスURL：http://localhost:8888/DT/shopping/cart.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;
use shopping\lib\Cart;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$cart = new Cart($db);

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);

// セッションに、セッションIDを設定する
$ses->checkSession();
$customer_no = $_SESSION['customer_no'];

// item_idを取得する
$item_id = (isset($_GET['item_id']) === true && preg_match('/^\d+$/', $_GET['item_id']) === 1) ? $_GET['item_id'] : '';
$crt_id = (isset($_GET['crt_id']) === true && preg_match('/^\d+$/', $_GET['crt_id']) === 1) ? $_GET['crt_id'] : '';
// var_dump($_GET);
// item_idが設定されていれば、ショッピングカートに登録する
if ($item_id !== '') {
    $res = $cart->insCartData($customer_no, $item_id);
    // 登録に失敗した場合、エラーページを表示する
    if ($res === false) {
        echo "商品購入に失敗しました。";
        exit();
    }
}

// crt_idが設定されていれば、削除する
if ($crt_id !== '') {
    $res = $cart->delCartData($crt_id);
}
// カート情報を取得する
$dataArr = $cart->getCartData($customer_no);
// アイテム数と合計金額を取得する。listは配列をそれぞれの変数にわける
// $cartSumAndNumData = $cart->getItemAndSumPrice($customer_no);
list($sumNum, $sumPrice) = $cart->getItemAndSumPrice($customer_no);

$context = [];
$context['sumNum'] = $sumNum;
$context['sumPrice'] = $sumPrice;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('cart.html.twig');
$template->display($context);
