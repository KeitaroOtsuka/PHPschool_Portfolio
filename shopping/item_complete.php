<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\member\complete.php
 * ファイル名：complete.php
 * アクセスURL：http://localhost:8888/DT/member/complete.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$template = $twig->loadTemplate('item_complete.html.twig');
$template->display([]);
