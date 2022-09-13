<?php
// ini_set('display_errors', "On");
session_start();
require('dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()){
  $_SESSION['time'] = time();
  // ログイン成功

  // ↓診療番号一覧を獲得するため
  $stmt = $db->prepare("select reserve_id from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id>200 order by reserve_id");
  $stmt->execute();
  $reserve_ids = $stmt->fetchall(PDO::FETCH_COLUMN);

  // ↓sessionからmemberidを取得
  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();

  $day = date('n月j日');

  // ↓本日分の未診療の数を出す
  $stmt = $db->prepare("select count(*) as number_cnt from reserve where created_time>=CURDATE() and situation='incomplete' and reserve_id > 200"); 
  $stmt->execute();
  $number_cnt = $stmt->fetch();
  $reserve_num = $number_cnt['number_cnt'] + 1;

  $stmt = $db->prepare('select max(reserve_id) as id_count from reserve WHERe created_time >= CURDATE() and reserve_id>200');
      $stmt->execute();
      $max_reserve = $stmt->fetch();
      $your_reserve_id = $max_reserve['id_count'] + 1;

if($max_reserve['id_count']<400){
// ↓重複エラーを出すため
  if(isset($_POST['btn'])){
    $stmt = $db->prepare("select count(member_id) as cnt from reserve where member_id=? and created_time>=CURDATE() and situation = 'incomplete'");
    $stmt->execute(array($member['id']));
    $duplication_id = $stmt->fetch();

    if(empty($duplication_id['cnt'])){
      if($reserve_ids){
    

      $stmt = $db->prepare("INSERT INTO reserve(member_id,reserve_id,created_time,situation) values(?,?,CURTIME(),'incomplete')");
      $stmt->execute(array($member['id'],$your_reserve_id));

      $_SESSION['reserve_id'] = $your_reserve_id;
      }else{
        $stmt = $db->prepare("INSERT INTO reserve(member_id,reserve_id,created_time,situation) values(?,201,CURTIME(),'incomplete')");
        $stmt->execute(array($member['id'])); 

        $_SESSION['reserve_id'] = 201;
      }

      header('Location: reserve_end.php');
      exit();
    }else{
      $error['duplication'] = 'duplication';
      }
    }
  }else{
    $error['over'] = 'over';
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

  <?php
  // チェックのためエラー表示の時間帯を正常とは違う設定にしてます。
  date_default_timezone_set('Asia/Tokyo');
  if(((date('H:i:s')>='23:59:00')) || (date(‘w’) == 6 || date(‘w’) == 7)): ?>
  <p>現在予約時間外です。</p>
  <p>土曜日、日曜日は休診日となります。</p>
  <p>ネット予約ができる時間帯は午後は17:00までになります。</p>
  <?php elseif($error['over'] == 'over'): ?>
    <p>本日の午後の予約は定員越えです。</p>
    <?php else: ?>
  <h1><?php echo date('n月j日'); ?>に新しく予約する</h1>

<body>
  <p>午後の待ち状況/診察番号一覧</p>
  
  <?php if($reserve_ids){
  foreach($reserve_ids as $rsv_id) : ?>
    <p class="rsv_num"><?= $rsv_id; ?></p>
    <?php endforeach;
  }else{?>
    <p class="not_rsv">【本日午前の予約はまだありません。】</p>
  <?php }
  if($error['duplication'] == 'duplication'): ?>
    <p class="duplication">本日既に予約されています。</p>
    <p class="link"><a href="login.php">ログインページ</a>からご確認ください。</p>
  <?php else: ?>
    <p class="text">現在予約すると午後の<span class="cnt"><?= $reserve_num; ?>番目</span>に予約できます。<br>本日予約しますか？</p>
  <form action="" method="POST">
    <input type="submit" name="btn" value="予約する" class="login">
  </form>
    <?php endif; ?>
    <?php endif; ?>
    <a href="login.php">戻る</a>
    <a href="../index.html" class="home">HOMEに戻る</a>
</body>
</html>