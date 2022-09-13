<?php
session_start();

// セッション情報を削除
$_SESSION = array();
if(ini_get("session.use_cookies")){
  $params = session_get_cookie_params();
  setcookie(session_name(), '' , time() - 42000,
  $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}
session_destroy();

// cookie情報も削除
setcookie('email', '', time()-3600);
setcookie('password', '', time()-3600);

header('Location: login.php');
?>
<!doctype html>
<html lang="ja">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="../../css/style.css">

<title>ログアウト</title>
</head>
<body>
<header>
<h1>ログアウト</h1>    
</header>

<main>
 
</main>
</body>    
</html>