<?php

//XSS対応
function h($stg) {
    return htmlspecialchars($stg, ENT_QUOTES);
}

//DB接続
function db_conn() {
  try {
    // 外部サーバーの設定
    $db_host = 'mysql3104.db.sakura.ne.jp'; 
    $db_name = 'atuy-amour_gs_db_class';         
    $db_user = 'atuy-amour_gs_db_class';              
    $db_password = 'coco1231';

      //ID:'root', Password: xamppは 空白 ''
      $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
      $pdo = new PDO($server_info, $db_user,$db_password);
      return $pdo; //PDOオブジェクトを返す
    } catch (PDOException $e) {
      // echo '接続エラー: ' . $e->getMessage(); // エラー内容を表示
      exit('DBConnectError:'.$e->getMessage());
    }
}

//SQLエラー
function sql_error($stmt) {
    $error = $stmt->errorInfo();
    exit("SQLエラー: " . $error[2]);
}

// ログインチェク処理 loginCheck()
function loginCheck()
{
    if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] != session_id()) {
        echo 'LOGIN Error!';
        exit('LOGIN ERROR');
    } else {
        session_regenerate_id(true);
        $_SESSION['chk_ssid'] = session_id();
    }
}
?>