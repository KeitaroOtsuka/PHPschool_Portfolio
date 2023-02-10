<?php

/*
 * ファイルパス：Applications\htdocs\DT\shopping\lib\Item.class.php
 * ファイル名：Item.class.php (商品に関するプログラムのクラスファイル、Model)
 */
namespace shopping\lib;

class Item
{
    public $cateArr = [];
    public $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // カテゴリーリストの取得
    public function getCategoryList()
    {
        $table = ' category ';
        $col = ' ctg_id, category_name ';
        $res = $this->db->select($table, $col);
        return $res;
    }

    // 商品リストを取得する
    public function getItemList($ctg_id)
    {
        // カテゴリーによって表示させるアイテムをかえる
        $table = ' item ';
        $col = ' item_id, item_name, price,image, ctg_id ';
        $where = ($ctg_id !== '') ? '  ctg_id = ? ' : '';
        $arrVal = ($ctg_id !== '') ? [$ctg_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    // 商品の詳細情報を取得する
    public function getItemDetailData($item_id)
    {
        $table = ' item ';
        $col = ' item_id, item_name, item_detail, price, image, ctg_id ';

        $where = ($item_id !== '') ? '  item_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($item_id !== '') ? [$item_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    // 商品を新規登録する
    public function insItemData($itemData)
    {
        $table = ' item ';
        return $this->db->insert($table, $itemData);
    }

    //画像をimageフォルダ下に保存する
    public function saveImageData($tmp_image)
    {
        // エラーがなく、サイズが0ではないか
        if ($tmp_image['error'] === 0 && $tmp_image['size'] !== 0) {
            // 正しくサーバにアップされているかどうか
        // is_uploaded_file：HTTP POSTでアップされたか調べる
            if (is_uploaded_file($tmp_image['tmp_name']) === true) {
                // 画像情報を取得する。getimagesize:画像のサイズ取得、mime他７つの値を連想配列で返す
                // なぜ、getimagesizeを使うのか？実際の画像を解析して、mimeを取得する。$_FILESはファイル名から判断して出力したmimeを出しているので改竄が可能
                $image_info = getimagesize($tmp_image['tmp_name']);
            // var_dump($image_info); echo '<br><br>';
            // MIME(マイム)：漢字(2バイト文字)や画像、音声を、半角英数字データ(文字列)に、変換して転送する。
                $image_mime = $image_info['mime'];
                // 画像サイズが利用できるサイズ以内かどうか
                if ($tmp_image['size'] > 1048576) {
                    echo 'アップロードできる画像のサイズは、1MBまでです';
                    // 画像の形式が利用できるタイプかどうか
                } elseif (preg_match('/^image\/jpeg$/', $image_mime) === 0) {
                    echo 'アップロードできる画像の形式は、JPEG形式(jpg/jpe/jpeg)だけです';
            // move_uploaded_file(ファイル名,名前)：アップされたファイルを新しい位置に移動させる。第二引数でディレクトリ＆名前を指定。
                    // time：現在時刻をUnixエポック(1970年1月1日00:00:00GMT)からの通算秒として返す(Unixタイムスタンプ)
                } elseif (move_uploaded_file($tmp_image['tmp_name'], './images/upload_' . time() . '.jpg') === true) {
                    echo '';
                }
            }
        }
    }
}
