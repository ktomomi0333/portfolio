<?php

// ini_set('display_errors', "On");
require('dbconnect.php');
session_start();

// ↓午前の待ち人数
$stmt = $db->prepare("select count(*) as cnt from reserve where created_time>=CURDATE() and reserve_id<=200");
$stmt->execute();
$am_num = $stmt->fetch();

// ↓午後の待ち人数
$stmt = $db->prepare("select count(*) as cnt from reserve where created_time>=CURDATE() and reserve_id>200");
$stmt->execute();
$pm_num = $stmt->fetch();

if(!empty($_POST)){
  if($_POST['name'] != '' && $_POST['tell'] != '' && $_POST['password'] != ''){
    $login = $db->prepare('SELECT * FROM members WHERE name=? AND tell=? AND password=?');
    $login->execute(array(
      $_POST['name'],
      $_POST['tell'],
      sha1($_POST['password'])
    ));
    $member=$login->fetch();

    if($member){
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();
    header('Location: login.php');
    exit();
  }else{
    $error['login'] = 'failed';
  }
}else{
  $error['login'] = 'blank';
}
}
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
  <h1>診察予約</h1>
</header>
<body>
  
  <div class="count">
    <h1>現在の予約人数</h1>
    <p class="rsv_num">午前：<?= $am_num['cnt']; ?>人</p>
    <p class="rsv_num">午後：<?= $pm_num['cnt']; ?>人</p>
  </div>
  <div class="login_wrapper">
  <h1>ログイン</h1>
  <p>登録をされている方は名前、電話番号、パスワードを記入してログイン・ご予約ください。</p>
  <p>必ず受診者の正確な名前をご記入ください。</p>
  <form action="" method="POST">
    <?php if ($error['login'] == 'blank'): ?>
      <p class="error">※名前、電話番号、パスワードを正しく入力して下さい。</p>
      <?php endif; ?>
      <?php if($error['login']=='failed'): ?>
        <p class="error">※ログインに失敗しました。正しくご記入ください。</p>
        <?php endif; ?>
    <dl>
      <dt>名前</dt>
      <dd>
        <input type="text" name="name" size="35" maxlength="255" style="width:100%" value="<?php echo htmlspecialchars($_POST['name'],ENT_QUOTES); ?>">
      </dd>
      <dt>電話番号</dt>
      <dd>
        <input type="tel" name="tell" size="35" maxlength="255" style="width:100%"  value="<?php echo htmlspecialchars($_POST['tell'],ENT_QUOTES); ?>"></dd>
      <dt>パスワード</dt>
      <dd>
        <input type="password" name="password" size="10" maxlength="20" style="width:100%" value="<?php echo htmlspecialchars($_POST['password'],ENT_QUOTES); ?>">
      </dd>  
    </dl>
  </div>
    <input type="submit" value="ログイン／予約" class="login">
  </form>
  
  <a href="register.php"><h2>新規登録</h2></a>
  <p class="error">初めての方はこちらから登録してください。</p>

  <a href="../index.html" class="home_btn">HOME</a>
  
</body>
</html>