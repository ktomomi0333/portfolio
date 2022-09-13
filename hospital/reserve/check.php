<?php
ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

if(!isset($_SESSION['join'])){
  header('Location: index.php');
  exit();
}

if(!empty($_POST)){
  $statement = $db->prepare('INSERT INTO members SET name=?,tell=?,password=?');
  $ret = $statement->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['tell'],
    sha1($_SESSION['join']['password'])
  ));
  unset($_SESSION['join']);
  header('Location: thanks.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>登録内容確認画面</title>
  <meta name="reserve" content="予約">

  <!-- デザイン崩れを防ぐ -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <!-- 他にCSSのファイルを用意して読み込む -->
  <link rel="stylesheet" href="CSS/style.css"> 
  <!-- google fontsの指定 -->
  <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">
</head>
<header>
  <h1>登録内容確認</h1>
</header>
<body>
  <form action="" method="POST">
    <input type="hidden" name="action" value="submit">
    <p class="check_text">以下の内容でよろしければ登録完了ボタンを押して下さい。</p>
    <div class="check_wrapper">
    <dl>
      <dt>名前</dt>
      <dd>
        <?= htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?> 
      </dd>
      <dt>電話番号</dt>
      <dd>
      <?= htmlspecialchars($_SESSION['join']['tell'], ENT_QUOTES); ?> 
      </dd>
      <dt>パスワード</dt>
      <dd>
        【表示されません】
      </dd>  
    </dl>
</div>
    <div class="rewrite_wrapper"><a href="register.php?action=rewrite" class="rewrite">書き直す</a><input type="submit" value="登録完了" class="rewrite"></div>
  </form>
</body>
</html>