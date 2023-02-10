<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\shopping\detail.php
 * ファイル名：detail.php (商品詳細を表示するプログラム、Controller)
 * アクセスURL：http://localhost:8888/DT/shopping/detail.php
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

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
   'cache' => Bootstrap::CACHE_DIR
]);

// セッションに、セッションIDを設定する
$ses->checkSession();

// item_idを取得する
$item_id = (isset($_GET['item_id']) === true && preg_match('/^\d+$/', $_GET['item_id']) === 1) ? $_GET['item_id'] : '';
// var_dump($item_id);

// item_idが取得できていない場合、商品一覧へ遷移させる
if ($item_id === '') {
    header('Location: ' . Bootstrap::ENTRY_URL. 'list.php');
}

// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();

// 商品情報を取得する
$itemData = $itm->getItemDetailData($item_id);
var_dump($itemData);

$context = [];
$context['cateArr'] = $cateArr;
$context['itemData'] = $itemData[0];// なぜ０が必要かは、$itemDataをvar_dumpしてみよう！
$template = $twig->loadTemplate('detail.html.twig');
$template->display($context);
