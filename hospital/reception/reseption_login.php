<?php
// ini_set('display_errors', "On");
session_start();

if(!empty($_POST)){
  if($_POST['rc_pass'] == '0000'){
    $_SESSION['rc_pass'] = $_POST['rc_pass'];

    header('Location: rsv_delete.php');
    exit();
  }else{
    $_error['false'] = 'false';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>portfolio</title>
  <meta name="description" content="ポートフォリオ">
  <!-- css -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link href="https://fonts.googleapis.com/css?family=philosopher" rel="stylesheet">
  <link rel="stylesheet" href="CSS/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, user-scalable=yes">
</head>
<body>
  <h1>ログイン画面</h1>
  <p>パスワードを入力してください。</p>
  <?php
  if($_error['false'] == 'false') :?>
  <p>正しいパスワードを入力してください。</p>
  <?php endif; ?>
  <form action="" method="POST">
    <input type="text" name="rc_pass">
    <input type="submit" value="送信">
  </form>
</body>
</html>