<?php
/*
 * ファイルパス：C:\xampp\htdocs\DT\shopping\lib\Session.class.php
 * ファイル名：Session.class.php (セッション関係のクラスファイル、Model)
 * セッション：サーバー側に一時的にデータを保存する仕組みのこと
 * 基本的に、keyで判断をして、IDを取るというのが流れ
 */
namespace shopping\lib;

class Session
{

    public $session_key = '';
    public $name = '';
    public $password = '';
    public $db = NULL;

    public function __construct($db)
    {
        // セッションをスタートする
        session_start();
        // セッションIDを取得する
        $this->session_key = session_id();
        // DBの登録
        $this->db = $db;
    }

    public function checkSession()
    {
        // セッションIDのチェック
        $customer_no = $this->selectSession();
        // セッションIDがある(過去にショッピングカートに来たことがある)
        if ($customer_no !== false) {
            $_SESSION['customer_no'] = $customer_no;
        } else {
            // セッションIDがない(初めてこのサイトに来ている)
            $res_session = $this->insertSession();
            if ($res_session === true) {
                $_SESSION['customer_no'] = $this->db->getLastId();
            } else {
                $_SESSION['customer_no'] = '';
            }
        }
    }

    private function selectSession()
    {
        $table = ' session ';
        $col = ' customer_no ';
        $where = ' session_key = ? ';
        $arrVal = [$this->session_key];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['customer_no'] : false;
    }

    private function insertSession()
    {
        $table = ' session ';
        $insData = ['session_key ' => $this->session_key];
        $res_session = $this->db->insert($table, $insData);
        return $res_session;
    }

    private function insertUserName()
    {
        $table = ' users ';
        $insData = ['user_name ' => $this->session_key];
        $res_user_name = $this->db->insert($table, $insData);
        return $res_user_name;
    }

    private function insertPassword()
    {
        $table = ' users ';
        $insData = ['password ' => $this->session_key];
        $res_password = $this->db->insert($table, $insData);
        return $res_password;
    }

    public function checkUserSession()
    {
        // セッションIDのチェック
        $user_id = $this->selectUserSession();
        // セッションIDがある(過去にショッピングカートに来たことがある)
        if ($user_id !== false) {
            $_SESSION['user_id'] = $user_id;
        } else {
            // セッションIDがない(初めてこのサイトに来ている)
            $res_session = $this->insertSession();
            if ($res_session === true) {
                $_SESSION['user_id'] = $this->db->getLastId();
            } else {
                $_SESSION['user_id'] = '';
            }
        }
    }

    private function selectUserSession()
    {
        $table = ' users ';
        $col = ' id ';
        $where = ' session_key = ? ';
        $arrVal = [$this->session_key];

        $res = $this->db->select($table, $col, $where, $arrVal);
        return (count($res) !== 0) ? $res[0]['id'] : false;
    }

    function logged_in() 
    {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }
}
