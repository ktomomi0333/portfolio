<?php
// ini_set('display_errors', "On");
session_start();
require('dbconnect.php');
if (!empty($_POST)){

  if($_POST['name'] == ''){
    $error['name'] = 'blank';
  }
  if($_POST['tell'] == ''){
    $error['tell'] = 'blank';
  }
  if(strlen($_POST['tell']) <10 | strlen($_POST['tell']) > 11){
    $error['tell'] = 'lenght';
  }
  if($_POST['password'] == ''){
    $error['password'] = 'blank';
  }
  if(strlen($_POST['password'])>0 && (strlen($_POST['password'])<4 | strlen($_POST['password'])>10)){
    $error['password'] = 'lenght';
  }
  if(empty($_error)){
    $records = $db->prepare('SELECT COUNT(*) AS cnt FROM members Where tell =? and name=?');
    $records->execute(array($_POST['tell'], $_POST['name']));
    $record = $records->fetch();
    if ($record['cnt']){
      $error['tell'] = 'duplicate';
    }
    if(empty($error)){
  
      $_SESSION['join'] = $_POST;
      header('Location: check.php');
      exit();
    }
  
  
  }
}
if($_REQUEST['action'] == 'rewrite'){
  $_POST = $_SESSION['join'];
}
  // 重複アカウントのチェック


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>plofile</title>
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
  <h1>新規登録</h1>
</header>
<body>
  <form action="" method="POST">
    <p>名前、電話番号、パスワードを入力して登録ボタンを押して下さい。</p>
    <div class="login_wrapper">
    <dl>
      <dt>名前</dt>
      <dd>
        <input type="text" name="name" size="35" maxlength="255" style="width:100%" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>" >
        <?php if($error['name'] == 'blank'): ?>
        <p class="error">※名前を入力して下さい</p>
        <?php endif; ?>
      </dd>
      <dt>電話番号</dt>
      <dd>
        <input type="INT" name="tell" size="35" maxlength="255" style="width:100%" value="<?php echo htmlspecialchars($_POST['tell'], ENT_QUOTES); ?>">
        <?php if($error['tell'] == 'blank' | $error['tell'] == 'lenght'): ?>
        <p class="error">※電話番号を正しく入力して下さい</p>
        <?php endif; ?>
        <?php if($error['tell'] == 'duplicate'): ?>
          <p class="error">※指定された電話番号は既に登録されています。</p>
        <?php endif; ?>
      </dd>
      <dt>※パスワード</dt>
      <p  class="error-pass">４文字以上10文字以下の英数字でご記入ください。</p>
      <dd>
        <input type="password" name="password" size="10" maxlength="20" style="width:100%" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>">
        <?php if($error['password'] == 'blank'): ?>
        <p class="error">※パスワードを入力してください</p>
        <?php endif; ?>
        <?php if($error['password'] == 'lenght'): ?>
        <p class="error">※パスワードの文字数を確認してください。</p>
        <?php endif; ?>
      </dd>  
    </dl>
    </div>
    <input type="submit" value="登録" class="login">
  </form>

  <a href="../index.html" class="home_btn">HOME</a>
</body>
</html>