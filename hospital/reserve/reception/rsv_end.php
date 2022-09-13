<?php
// ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

$member['reserve_id'] = $_SESSION['reserve_id'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>予約削除完了画面</title>
  <meta name="reserve" content="予約">

  <!-- デザイン崩れを防ぐ -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <!-- 他にCSSのファイルを用意して読み込む -->
  <link rel="stylesheet" href="/CSS/style.css"> 
  <!-- google fontsの指定 -->
  <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
</head>
<body>
  <p>診療番号<?= $member['reserve_id']; ?>の削除が完了しました。</p>
  <a href="rsv_delete.php">診療終了画面に戻る</a>
</body>
</html>