<?php 
namespace shopping\admin; 
require_once '/Applications/MAMP/htdocs/Portfolio/shopping/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);

$ses->checkUserSession();
if(!$ses->logged_in()) {
  header('Location: ' . Bootstrap::ADMIN_URL. 'login_form.php');
}

$dataArr = $db->select('item');

$context = [];
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('admin_item_index.html.twig');
$template->display($context);
?>
