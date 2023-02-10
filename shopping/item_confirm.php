<?php
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;
use shopping\lib\Item;
use shopping\lib\Common;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$itm = new Item($db);
$common = new Common();

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);

// モード判定(どの画面から来たかの判断)
// 登録画面から来た場合
if (isset($_POST['confirm']) === true) {
    $mode = 'confirm';
}
// 戻る場合
if (isset($_POST['back']) === true) {
    $mode = 'back';
}
// 登録完了
if (isset($_POST['complete']) === true) {
    $mode = 'complete';
}
// ボタンのモードよって処理をかえる
switch ($mode) {
    case 'confirm': // 新規登録
                    // データを受け継ぐ
                    // ↓この情報は入力には必要ない
        unset($_POST['confirm']);
    
        $dataArr = $_POST;
        $dataArr['image'] = $_FILES['image'];
        $res = $itm->saveImageData($dataArr['image']);

        // この値を入れないでPOSTするとUndefinedとなるので未定義の場合は空白状態としてセットしておく
        if (isset($_POST['ctg_id']) === false) {
            $dataArr['ctg_id'] = "";
        }

        // エラーメッセージの配列作成
        $errArr = $common->errorCheck($dataArr);
        $err_check = $common->getErrorFlg();
        $err_check = true;
        // err_check = false →エラーがありますよ！
        // err_check = true →エラーがないですよ！
        // エラー無ければconfirm.tpl あるとregist.tpl
        $template = ($err_check === true) ? 'item_confirm.html.twig' : 'item_regist.html.twig';
        break;

    case 'back': // 戻ってきた時
                 // ポストされたデータを元に戻すので、$dataArrにいれる
        $dataArr = $_POST;

        unset($dataArr['back']);

        // エラーも定義しておかないと、Undefinedエラーがでる
        foreach ($dataArr as $key => $value) {
            $errArr[$key] = '';
        }

        $template = 'regist.html.twig';
        break;

    case 'complete': // 登録完了
        $itemData = $_POST;
        $image = $_POST['image'];
        $itemData['image'] = $image[0];
        
        
        // exit;

        // var_dump($res);
        // echo '<br>';
        // echo $image[2], './images/' . $image[0];
        // exit;
        // if (move_uploaded_file($image[2], './images/' . $image[0]) === false) {
        //     echo '失敗';
        //     exit;
        // }

        // /Applications/MAMP/tmp/php/php5ewkH1./upload_1674069605.jpg
        // /Applications/MAMP/tmp/php/phpLxejBe./images/jagaimo.jpeg

        // ↓この情報はいらないので外しておく
        unset($itemData['complete']);
        // $column = '';
        // $insData = '';

        // // foreachの中でSQL文を作る
        // foreach ($dataArr as $key => $value) {
        //     $column .= $key . ', ';
        //     // if ($key === 'traffic') {
        //     //     $value = implode('_', $value);
        //     // }
        //     // $insData .= ($key === 'sex') ? $db->quote($value) . ',' : $db->str_quote($value) . ', ';
        // }
            
        $res = $itm->insItemData($itemData);
        // var_dump($res);
        if ($res === true) {
            // 登録成功時は完成ページへ
            header('Location: ' . Bootstrap::ENTRY_URL . 'item_complete.php');
            exit();
        } else {
            // 登録失敗時は登録画面に戻る
            $template = 'item_regist.html.twig';

            foreach ($dataArr as $key => $value) {
                $errArr[$key] = '';
            }
        }

        break;
}
$i = 0;
foreach ($itm->getCategoryList() as $key => $val) {
    $ctgArr[$i] = $val['category_name'];
    $i ++;
}
// var_dump($dataArr['image']);
$context = [];
$context['dataArr'] = $dataArr;
$context['errArr'] = $errArr;
$context['ctgArr'] = $ctgArr;

$template = $twig->loadTemplate($template);
$template->display($context);
