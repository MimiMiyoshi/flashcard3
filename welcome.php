<?php
session_start();
require_once('funcs.php');

// セッションにuser_idが存在するか確認
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // user_idが存在しない場合はログインページにリダイレクトするなど適切な処理を行う
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Welcome</title>
    <style>
        body {
            background-image: url('css/files/yellow.webp');
            margin: 0;
            padding: 0;
            min-height: 100vh; /* 画面の高さいっぱいに表示 */
            background-size: cover; /* 画像を大きさいっぱいに表示 */
            background-position: center; /* 画像を中央に表示 */
            background-repeat: no-repeat; /* 画像を繰り返さない */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .message-box {
            /* background: white; */
            /* padding: 20px 40px; */
            /* border-radius: 10px; */
            /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
            text-align: center;
        }
  
        h1 {
            text-align: center;
            margin: 10px 0;
            font-size: 40px;
            font-weight: bold;
            color: white;
            text-shadow: 3px 3px 6px black, -3px -3px 6px black;
            }

        p {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px black, -2px -2px 4px black;
        }
        
    </style>
    <script>
        // 5秒後に自動的にindex.phpにリダイレクト
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="message-box">
        <h1>  Welcome!</h1>
        <p>  <?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>さん、今日も頑張りましょう！</p>
    </div>
</body>
</html>
