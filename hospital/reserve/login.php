<?php
// ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $_SESSION['time'] = time();
  // ログイン成功

  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

  // 自分のreserve_idを$rsv_idに代入
  $stmt = $db->prepare('SELECT reserve_id FROM reserve WHERE member_id=? and created_time>=CURDATE()');
  $stmt->execute(array($member['id']));
  $rsv_id = $stmt->fetch();

  // 自分が何番目の診察か数えるため$num_cntに代入
  $stmt = $db->prepare("select count(*) as num_cnt from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id <=?"); 
  $stmt->execute(array($rsv_id['reserve_id']));
  $num_cnt = $stmt->fetch();
  
  ;
}else{
  // ログインしていない
  header('Location: reservetop.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>予約状況</title>
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
  <h1>現在の予約状況</h1>
</header>
<body>
  <h1>ログインしました。</h1>
  
  <p><?php echo htmlspecialchars($member['name'], ENT_QUOTES); ?>様の現在の予約状況</p>
  <?php if($rsv_id['reserve_id']) :
      if($rsv_id['reserve_id'] <= 200) : ?>
        <p class="now">本日診療番号<span class="strong"><?= $rsv_id['reserve_id']; ?>番</span>に予約されています。</p>
        <p>現在午前の<span class="strong"><?= $num_cnt['num_cnt']; ?>番目</span>の診療ですので順番が近くなり次第来院してください。</p>
        <p>※来院時間が遅れた際は診療順番が前後することがありますのでご了承ください。</p>
        <?php else: ?>
          <p>本日診療番号<span class="strong"><?= $rsv_id['reserve_id']; ?>番</span>に予約されています。</p>
  <div class="text">
        <p>現在午後の<?= $num_cnt['num_cnt']; ?>番目の診療ですので順番が近くなり次第来院してください。</p>
        <p>※来院時間が遅れた際は診療順番が前後することがありますのでご了承ください。</p>
      <?php endif; ?>
    <?php else : ?>
      <p class="login_text">本日の診療予約はまだされていません。</p>
      <?php endif; ?>
  </div>

  <a href="am.php" class="ampm"><?php echo date('n月j日'); ?>の午前に新しく予約する<br>午前の診療番号は1番〜200番です。</a>
  <a href="pm.php" class="ampm"><?php echo date('n月j日'); ?>の午後に新しく予約する<br>午後の診療番号は201番〜400番です。</a>  
  <a href="delete.php" class="delete_btn">予約の取り消し</a>
  <p class="error login_text">※予約を変更する際は予約を取り消した後、改めて新しくご予約ください。</p>

  <div class="jamp">
    <a href="reservetop.php">戻る</a>
    <a href="../index.html">Home</a>
  </div>
  
</body>
</html>