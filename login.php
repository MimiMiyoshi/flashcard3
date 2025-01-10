
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/background.css" />
    <link rel="stylesheet" href="css/signup.css" />
  </head>

  <body>

    <div id="register-screen" class="screen">
      <div id="background"></div>
   
      <div class="box">
      <div class="title-container">
      <h1>Login</h1>
      </div>
          <!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
    <form action="login_act.php" method="post" class="loginform">
        <input type="text" name="user_id" placeholder="ユーザー名を入力" required/>
        <input type="password" name="password" placeholder="パスワードを入力" required/>
        <button type="submit" class="button">Login</button>
        <p>Don't have an account? <a href="signup.php">Signup</a></p>
    </form>

    </div>

    </div>
  </body>
</html>
