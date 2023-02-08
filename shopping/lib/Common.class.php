<?php
namespace shopping\lib;

class Common
{
    private $dataArr = [];

    private $errArr = [];

    public function errorCheck($dataArr)
    {
        $this->dataArr = $dataArr;
        // クラス内のメソッドを読み込む
        $this->createErrorMessage();

        $this->itemNameCheck();
        $this->ctgCheck();
        $this->priceCheck();
        $this->detailCheck();

        $image = $this->imageCheck();

        return [$this->errArr, $image];
    }

    private function createErrorMessage()
    {
        foreach ($this->dataArr as $key => $val) {
            $this->errArr[$key] = '';
        }
    }

    private function itemNameCheck()
    {
        if ($this->dataArr['item_name'] === '') {
            $this->errArr['item_name'] = '商品名を入力してください';
        }
    }

    private function ctgCheck()
    {
        if ($this->dataArr['ctg_id'] === '') {
            $this->errArr['ctg_id'] = 'カテゴリーを選択してください';
        }
    }

    private function priceCheck()
    {
        if (preg_match('/^\d{1,6}$/', $this->dataArr['price']) === 0 ||
            strlen($this->dataArr['price']) >= 12) {

            $this->errArr['tel1'] = '金額は、半角数字で11桁以内で入力してください';

        }
    }

    private function detailCheck()
    {
        if ($this->dataArr['item_detail'] === '') {
            $this->errArr['item_detail'] = '商品説明を入力してください';
        }
    }

    private function imageCheck()
    {
        $image = $this->dataArr['image'];

        if ($image === '') {
            $this->errArr['image'] = '画像をアップロードしてください';
        } else {
            if ($image['error'] === 0 && $image['size'] !== 0) {
                if (is_uploaded_file($image['tmp_name']) === true) {
                    $image_info = getimagesize($image['tmp_name']);
                    $image_mime = $image_info['mime'];
                    if ($image['size'] > 1048576) {
                        $this->errArr['image'] = 'アップロードできる画像のサイズは、1MBまでです';
                    } elseif (preg_match('/^image\/jpeg$/', $image_mime) === 0) {
                        $this->errArr['image'] = 'アップロードできる画像の形式は、JPEG形式(jpg/jpe/jpeg)だけです';
                    } else {
                        return $image;
                    }
                } else {
                    $this->errArr['image'] = '正しくアップロードされませんでした';
                }
            } else {
                $this->errArr['image'] = 'エラーが発生しました';
            }
        }
    }

    public function getErrorFlg()
    {
        $err_check = true;
        foreach ($this->errArr as $key => $value) {
            if ($value !== '') {
                $err_check = false;
            }
        }
        return $err_check;
    }
}
