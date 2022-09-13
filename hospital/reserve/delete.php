<?php
// ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $_SESSION['time'] = time();
  // ログイン成功

  
  // ↓sessionからmemberidを取得
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

  // ↓午前の診療番号一覧
  $stmt = $db->prepare("select reserve_id from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id<=200 order by reserve_id");
  $stmt->execute();
  $am_ids = $stmt->fetchall(PDO::FETCH_COLUMN);

  // ↓午後の診療番号一覧
  $stmt = $db->prepare("select reserve_id from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id>200 order by reserve_id");
  $stmt->execute();
  $pm_ids = $stmt->fetchall(PDO::FETCH_COLUMN);

  // ↓本人の$reserve_idを作る
  $stmt = $db->prepare("select reserve_id from reserve where member_id=? and situation = 'incomplete' and created_time>=CURDATE()");
  $stmt->execute(array($member['id']));
  $rsv_id = $stmt->fetch();

  if(isset($_POST['btn'])){
    $stmt = $db->prepare('DELETE FROM `reserve` WHERE reserve_id=? and created_time>=CURDATE()');
    $stmt->execute(array($rsv_id['reserve_id'])); 
    
    header('Location: delete_end.php');
  }
  
}else{
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


<body>
  <p>現在予約されている診察番号一覧</p>
  <p>【午前】</p>
  <?php foreach($am_ids as $am_id) : ?>
    <p class="rsv_num"><?= $am_id; ?></p>
    <?php endforeach; ?>
  <p>【午後】</p>
  <?php foreach($pm_ids as $pm_id) : ?>
    <p class="rsv_num"><?= $pm_id; ?></p>
    <?php endforeach; ?>
    <?php if($rsv_id['reserve_id']) : ?>
    <p><?= $member['name'];?>様の診療番号は<span class="cnt"><?= $rsv_id['reserve_id']; ?>番</span>です。</p>
    <p class="text">削除の取り消しはできませんが、本当に削除しますか？</p>
     <form action="" method="post">
       <input type="submit" name="btn" value="削除する" class="btn">
     </form>
  <?php else :?>
    <p>本日はまだ予約はしておりません。</p> 
  <?php endif; ?>
  <a href="login.php">戻る</a>
  <a href="index.html">HOMEに戻る</a>

</body>
</html>