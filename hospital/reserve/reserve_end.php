<?php
ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $_SESSION['time'] = time();
  // ログイン成功

  $your_reserve_id = $_SESSION['reserve_id'];

  // ↓午前診療番号一覧を獲得するため
  $stmt = $db->prepare("select reserve_id from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id<=200 order by reserve_id");
  $stmt->execute();
  $pm_ids = $stmt->fetchall(PDO::FETCH_COLUMN);

  // ↓午後診療番号一覧を獲得するため
  $stmt = $db->prepare("select reserve_id from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id>200 order by reserve_id");
  $stmt->execute();
  $am_ids = $stmt->fetchall(PDO::FETCH_COLUMN);
  
  }else{
  header('Location: login.php');
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
  <h1>予約完了</h1>
</header>
<body>
<p></p>
<p>診察番号一覧</p> 
<?php if($your_reserve_id<=200){
  foreach($pm_ids as $pm_id) : ?>
    <p class="rsv_num"><?= $pm_id; ?></p>
    <?php endforeach;
}else{
  foreach($am_ids as $am_id) : ?>
    <p class="rsv_num"><?= $am_id; ?></p>
    <?php endforeach;
}?>



<p>予約が完了しました。</p>
<p class="reserve_id">あなたの診察番号は<span class="cnt"><?= $your_reserve_id; ?>番</span>です。</p>

<a href="login.php" class="to_btn">予約トップページに戻る</a>
<a href="../index.html" class="home">HOMEに戻る</a>
</body>
</html>