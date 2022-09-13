<?php
// ini_set('display_errors', "On");
session_start();
require('../reserve/dbconnect.php');

if(!isset($_SESSION['rc_pass'])){
  header('Location: reseption_login.php');
  exit();
}else{

  if(isset($_POST['reserve_id'])){

    $stmt = $db->prepare("SELECT count(*) as rsv_cnt from reserve where reserve_id = ? and created_time>=CURDATE() and situation='incomplete'");
    $stmt->execute(array($_POST['reserve_id']));
    $rsv_cnt = $stmt->fetch();

      if($rsv_cnt['rsv_cnt']){

      $_SESSION['reserve_id'] = $_POST['reserve_id'];
      
      header('Location: rsv_check.php');
      }else{
        $error['not_ex'] = 'not_exist';
      }
  }else{
    $error['emp'] = 'emp';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>診療終了</title>
  <meta name="reserve" content="予約">

  <!-- デザイン崩れを防ぐ -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <!-- 他にCSSのファイルを用意して読み込む -->
  <link rel="stylesheet" href="CSS/style.css">
  <!-- google fontsの指定 -->
  <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
  <meta name="viewport" content="width=device-width",initial-scale=1.0>
</head>
<body>
  <p>診療が終わった人の診療番号を入力してください。</p>
  <p class="error">※診療完了を押したら予約から削除されます。※</p>
  <?php if($error['emp'] == 'emp'): ?>
    <p>診療番号を入力してください。</p>
    <?php elseif($error['not_ex'] == 'not_exist') : ?>
      <p class="error">※その診療番号は本日予約していません。</p>
    <?php endif; ?>
 <form action="" method="post">
 <input type="text" name="reserve_id">
 <input type="submit" value="診療完了">
 <a href="reseption_login.php">ログイン画面に戻る</a>
 </form>
</body>
</html>