<?php
session_start();
require('dbconnect.php');

if(isset($_SESSION['id'])){
  $id = $_REQUEST['id'];

// 投稿を検査する
$messages = $db->prepare('SELECT * FROM posts WHERE id=?');
$messages->execute(array($id));
$message = $messages->fetch();

if($message['member_id'] == $_SESSION['id']){
  // 削除する
  $del = $db->prepare('DELETE FROM posts WHERE id=?');
  $del->execute(array($id));
}
}

header('Location: index.php');
exit();
?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="CSS/style.css">

<title>削除</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">削除</h1>    
</header>

<main>
  
</main>
</body>    
</html>