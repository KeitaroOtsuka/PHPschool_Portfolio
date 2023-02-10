<?php namespace shopping\admin; 
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

$id = (isset($_GET['id']) === true && preg_match('/^\d+$/', $_GET['id']) === 1) ? $_GET['id'] : '';
if ($id !== '') {
  $res = $db->delUsersData($id);
}

$users = $db->select('users', 'id, name, mail, role, delete_flg');

$context = [];
$context['users'] = $users;
$template = $twig->loadTemplate('admin_index.html.twig');
$template->display($context);
?>
