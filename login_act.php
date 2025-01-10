<?php
session_start();
require_once('funcs.php');
$pdo = db_conn();

//1. POSTデータ取得
$user_id = $_POST['user_id'];
$password = $_POST['password']; // 生のパスワードを取得

//2. データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");  
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR); 
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch(); //1レコードだけ取得する方法

var_dump($val); // $valの中身を確認
if ($val) {
    var_dump($password); // 入力されたパスワード
    var_dump($val['password_hash']); // データベースのハッシュ
    var_dump(password_verify($password, $val['password_hash'])); // 検証結果
}

if ($val && password_verify($password, $val['password_hash'])) { // ハッシュ化せずに比較
    //Login成功時
    $_SESSION['chk_ssid']  = session_id();
    $_SESSION['admin_flg'] = $val['admin_flg'];
    $_SESSION['user_id']   = $val['user_id'];
    header('Location: welcome.php');
} else {
    //Login失敗時(Logout経由)
    header('Location: login.php');
}
exit();
?>
