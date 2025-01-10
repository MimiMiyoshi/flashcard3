<?php
session_start();

// データベース接続
require_once('funcs.php'); // db_conn() を含む関数ファイル
$pdo = db_conn();

// メッセージを格納する変数
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

       // フォームが送信された場合の処理
       if (empty($_POST['user_id']) || empty($_POST['password'])) {
        $error_message = "ユーザー名またはパスワードが入力されていません。";
    } else {
        
// POSTデータの取得
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$profile_image = $_FILES['profile_image'];

// ユーザーIDの重複チェック
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->execute();
$count = $stmt->fetchColumn();

if ($count > 0) {
    // 重複エラーメッセージを表示
    $_SESSION['error'] = 'このユーザーIDは既に使用されています。';
    header('Location: signup.php');
    exit();
} else {

// パスワードのハッシュ化
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// プロフィール画像の処理
 // プロフィール画像のアップロード処理
 $profile_image_path = null;
 if ($profile_image['size'] > 0) {
     $upload_dir = 'image/';
     $profile_image_path = $upload_dir . basename($profile_image['name']);
     move_uploaded_file($profile_image['tmp_name'], $profile_image_path);
 }

//         // ファイル拡張子チェック
//     $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
//     $file_extension = pathinfo($profile_image['name'], PATHINFO_EXTENSION);
//     if (!in_array(strtolower($file_extension), $allowed_extensions)) {
//         exit('許可されていないファイル形式です。');
//     }

// データ登録SQL作成
$stmt = $pdo->prepare("
    INSERT INTO users (user_id, password_hash, profile_image_path, admin_flg, is_active)
    VALUES (:user_id, :password_hash, :profile_image_path, 0, 1)
");

$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
$stmt->bindValue(':profile_image_path', $profile_image_path, PDO::PARAM_STR);
$status = $stmt->execute();

    //3. SQL実行時にエラーがある場合
    if ($status == false) {
        sql_error($stmt);
    } else {
        //4. 登録成功時
        // header('Location: login.php');
        // exit();
            // 成功メッセージを表示するモーダルを表示
    echo '<div id="success-modal" class="modal">
    <div class="modal-content">
        <p>登録が完了しました！</p>
        <button onclick="redirectToLogin()">ログイン画面へ</button>
    </div>
  </div>';
    }

}
}
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Signup</title>
    <link rel="stylesheet" href="css/background.css" />
    <link rel="stylesheet" href="css/signup.css" />
  </head>

  <body>

    <div id="register-screen" class="screen">
      <div id="background"></div>
      <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']); 
                ?>
            </div>
        <?php endif; ?>
<div class="box">
    <div class="title-container">
      <h1>Signup</h1>
      </div>
    <form action="signup.php" method="post" enctype="multipart/form-data" class="loginform">
        <input type="text" id="user_id" name="user_id" placeholder="ユーザー名を入力" required/>

        <input type="password" id="password" name="password" placeholder="パスワードを入力" required/>

        <label for="profile_image">プロフィール画像を選択する (任意):</label>
        <input type="file" id="profile_image" name="profile_image" accept="image/*"/>

        <button type="submit" class="button">Create Account</button>
    </form>
    </div>
    </div>
    <script>
function redirectToLogin() {
    window.location.href = 'login.php';
}
</script>
 
  </body>
</html>

