<?php
session_start();
require('../dbconnect.php');
// error_reporting(0);
error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if(!empty($_POST)){
  if($_POST['name'] ==''){
    $error['name'] = 'blank';
  }
  if($_POST['email'] ==''){
    $error['email'] = 'blank';
  }
  if(strlen($_POST['password']) < 4){
    $error['password'] = 'length';
  }
  if($_POST['password'] ==''){
    $error['password'] = 'blank';
  }
  $fileName = $_FILES['image']['name'];
  if(!empty($fileName)){
    $ext = strtolower(substr($fileName, -4));
    if ($ext != '.jpg' && $ext != '.gif' && $ext != '.png'){
      $error['image'] = 'type';
    }
  }

  // 重複アカウントのチェック
  if (empty($_error)){
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0){
      $error['email'] = 'duplicate';
    }
  }
  // 画像のアップロード
  if(empty($error)){
  if(!empty($fileName)){
    $image = date('YmdHis') . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $image);
  }else{
    $image = "NoImage.png";
  }
    $_SESSION['join'] = $_POST;
    $_SESSION['join']['image'] = $image;
    header('Location: check.php');
    exit();
  }


  // if(empty($error)){
  //   $filePath = date('YmdHis') . $fileName;
  //   if (DIRECTOTY_SEPARATOR == "\\"){
  //     // windowsの場合（文字コードshift_jisnoの場合）
  //     $sjisPath = mb_convert_encoding($filePath,"SJIS","UTF-8");
  //     move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $sjisPath);
  //   }else{
  //     move_uploaded_file($_FILES['image']['tmp_name'], '../member_picture/' . $filePath);
  //   }

  //   $_SESSION['join'] = $_POST;
  //   $_SESSION['join']['image'] = $filePath;
  //   // $_SESSION['join']['image'] = $image;
  //   header('Location: check.php');
  //   exit();
  // }
}

if ($_REQUEST['action'] == 'rewrite'){
  $_POST = $_SESSION['join'];
  // fileの内容を改めて指定するため
  $error['rewrite'] = true;
}

?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=yes">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../CSS/style.css">

<title>会員登録</title>
</head>
<body>
<header>
<h1 class="font-weight-normal">会員登録</h1>    
</header>

<main>
<p>次のフォームに必要事項をご記入ください。</p>
<form action="" method="post" enctype="multipart/form-data">
  <dl>
    <dt>ニックネーム<span class="required">※必須※</span></dt>
    <dd>
      <input type="text" name="name" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES); ?>"/>
      <?php if ($error['name'] =='blank'): ?>
        <p class="error">※ニックネームを入力してください</p>
      <?php endif; ?>  
    </dd>
    <dt>メールアドレス<span class="required">※必須※</span></dt>
    <dd>
      <input type="text" name="email" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES); ?>" />
      <?php if ($error['email'] =='blank'): ?>
        <p class="error">※メールアドレスを入力してください</p>
      <?php endif; ?> 
      <?php if ($error['email'] == 'duplicate'): ?>
        <p class="error">※指定されたメールアドレスはすでに登録されています</p>
        <?php endif; ?>
    </dd>
    <dt>パスワード<span class="required">※必須※</span></dt>
    <dd>
      <input type="password" name="password" size="10" maxlength="20" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES); ?>"/>
      <?php if ($error['password'] =='blank'): ?>
        <p class="error">※パスワードを入力してください</p>
      <?php endif; ?> 
      <?php if ($error['password'] =='length'): ?>
        <p class="error">※パスワードは４文字以上で入力してください</p>
      <?php endif; ?> 
    </dd>
    <dt>写真など</dt>
    <dd>
      <input type="file" name="image" size="35" />
      <?php if($error['image'] =='type'): ?>
        <p class="error">※写真などは「.gif」または「.jpg」の画像を指定してください。</p>
        <?php endif; ?>
        <?php if(!empty($error)): ?>
        <p class="error">※恐れ入りますが、画像を改めて指定して下さい</p>
        <?php endif; ?>
    </dd>
  </dl>
  <div><input type="submit" value="入力内容を確認する" class="btn"></div>
</form>
</main>
</body>    
</html>