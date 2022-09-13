<?php
error_reporting(E_ERROR | E_PARSE | E_NOTICE);
// error_reporting(0);

require('dbconnect.php');

session_start();

if (!empty($_COOKIE['email']) && !empty($_COOKIE['password']) && $_COOKIE['email'] != ''){
  $_POST['email'] = $_COOKIE['email'];
  $_POST['password'] = $_COOKIE['password'];
  $_POST['save'] = 'on';
}

if(!empty($_POST)){
  if ($_POST['email'] != '' && $_POST['password'] != ''){
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array($_POST['email'], sha1($_POST['password'])));
    $member = $login->fetch();

    if($member){
      // ログイン成功
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      // ログイン情報を記録する
      if($_POST['save'] =='on'){
        setcookie('email',$_POST['email'],time()+60*60*24*14);
        setcookie('password',$_POST['password'],time()+60*60*24*14);
      }

      header('Location: index.php');
      exit();
    }else{
      $error['login'] = 'failed';
    }
    }else{
      $error['login'] = 'blank';
    }
}
?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="CSS/style.css">

<title>ログイン画面</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">ログイン画面</h1>    
</header>

<main>
<div id="lead">
 <p>メールアドレスとパスワードを記入してログインしてください。</p>
 <p>入会手続きがまだの方はこちらからどうぞ</p>
 <p>&raquo;<a href="join/index.php">入会手続きをする</a></p>
</div>
<form action="" method="post">
  <dl>
    <dt>メールアドレス</dt>
    <dd>
      <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>"/>
      <?php if ($error['login'] == 'blank'): ?>
        <p class="error">※メールアドレスとパスワードをご記入ください。</p>
      <?php endif; ?>
      <?php if ($error['login'] == 'failed'): ?>
        <p class="error">ログインに失敗しました。正しくご記入ください。</p>
      <?php endif; ?>
    </dd>
    <dt>パスワード</dt>
    <dd>
      <input type="password" name="password" size="35" maxlength="225" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>" />
    </dd>
    <dt>ログイン情報の記録</dt>
    <dd>
      <input id="save" type="checkbox" name="save" value="on"><label for="save">次回からは自動的にログインする</label>
    </dd>
  </dl>
  <div><input type="submit" value="ログインする" class="btn"></div>
</form>
</main>
</body>    
</html>