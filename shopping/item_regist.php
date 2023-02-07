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

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);

// 初期データを設定
$dataArr = [
    'item_name' => '',
    'item_detail' => '',
    'price' => '',
    'image' => '',
    'ctg_id' => ''
];

// エラーメッセージの定義、初期
$errArr = [];
foreach ($dataArr as $key => $value) {
    $errArr[$key] = '';
}

$categoryArr = $itm->getCategoryList();
// var_dump($categoryArr);
$context = [];

$context['categoryArr'] = $categoryArr;
$context['dataArr'] = $dataArr;
$context['errArr']= $errArr;

$template = $twig->loadTemplate('item_regist.html.twig');
$template->display($context);