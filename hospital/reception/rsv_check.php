<?php
ini_set('display_errors', "On");
session_start();
require('../reserve/dbconnect.php');

$member['reserve_id'] = $_SESSION['reserve_id'];

if(isset($_POST)){
  $stmt = $db->prepare("UPDATE reserve SET situation='complete' WHERE reserve_id=? and created_time>=CURDATE()");
  $stmt->execute(array($member['reserve_id']));

  $_SESSION['reserve_id'] = $member['reserve_id']; 

  header('Location: rsv_end.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>予約削除画面</title>
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
  <p>一度削除するともとに戻せませんが次の診療番号を予約から本当に削除しますか？</p>
  <p><?= $member['reserve_id']; ?> </p>
 <form action="" method="post">
 <!-- 診療番号を表示する -->
 <input type="submit" value="削除を確定する">
 </form>
 <a href="rsv_delete.php">削除せずに戻る</a>
</body>
</html>