<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // POSTでのアクセスでない場合
    $name = '';
    $email = '';
    $subject = '';
    $message = '';
    $err_msg = '';
    $complete_msg = '';

} else {
    // フォームがサブミットされた場合（POST処理）
    // 入力された値を取得する
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // エラーメッセージ・完了メッセージの用意
    $err_msg = '';
    $complete_msg = '';

    // 空チェック
    if ($name == '' || $email == '' || $subject == '' || $message == '') {
        $err_msg = '全ての項目を入力してください。';
    }

    // エラーなし（全ての項目が入力されている）
    if ($err_msg == '') {
        $to = 'tome.1812@icloud.com'; // 管理者のメールアドレスなど送信先を指定
        $headers = "From: " . $email . "\r\n";

        // 本文の最後に名前を追加
        $message .= "\r\n\r\n" . $name;

        // メール送信
        mb_send_mail($to, $subject, $message, $headers);

        // 完了メッセージ
        $complete_msg = '<center><span style="color:red">送信されました！</span> </center>';

        // 全てクリア
        $name = '';
        $email = '';
        $subject = '';
        $message = '';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>portfolio</title>
  <meta name="description" content="ポートフォリオ">
  <!-- css -->
  <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
  <link href="https://fonts.googleapis.com/css?family=philosopher" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0 minimum-scale=1, user-scalable=yes">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
  <header>
    <nav>
      <ul class="pc-menu">
        <li><a href="#profile">プロフィール</a></li>
        <li><a href="#skill">スキル</a></li>
        <li><a href="#work">作品</a></li>
        <li><a href="#contact">お問い合わせ</a></li>
      </ul>
    </nav>
    <div class="sp-menu">
      <span class="material-icons" id="open">menu</span>
    </div>

    <h1>PORTFOLIO</h1>
  </header>

  <div class="overlay">
    <span class="material-icons" id="close">close</span>
    <nav>
      <ul>
        <li><a href="#profile">プロフィール</a></li>
        <li><a href="#skill">スキル</a></li>
        <li><a href="#work">作品</a></li>
        <li><a href="#contact">お問い合わせ</a></li>
      </ul>
    </nav>
  </div>

  <h2 id="profile">−　プロフィール　−</h2>
  <div class="pro">
    <img class="photo" src="images/photo.jpg">
    <div class="pro-text">
      <p class="me">　　名前：菊池　那美</p>
      <p class="me">生年月日：１９８６年１２月１８日</p>
      <p class="me">　　年齢：３５歳</p>
      <p class="me">　　趣味：釣り、アニメ鑑賞、ゲーム</p>
    </div><!-- pro-text -->
  </div><!-- pro -->

  <!-- 強み -->
<div class="strongs">
  <h2>−　私の強み　−</h2>
  <h3>①協調性・コミュニケーション能力</h3>
   <p class="strong">周囲の状況を把握することができ、前職ではリーダーとしての業務を行なっていました。
    「相手が求めているものは何か」を考えながら行動することで、グループ内の意見を業務に反映させスムーズに進行するように調整していました。他職種とも積極的にコミュニケーションを図り、他職種との連携も図ることができます。</p>
  <h3>②自己研鑽</h3>
   <p class="strong">元々一つの分野を勉強しだすと追求する性格です。就職活動をする以前にはプログラミングの勉強も兼ねて自己研鑽し、資格取得することができました。現在はプログラミング言語の勉強や基本情報技術者試験の資格取得に向けての勉強を継続しています。</p>
</div>
  <!-- 強み -->

 <!-- 将来像 -->
<div class="target">
  <h2>− 目指す将来像 −</h2>
  <p class="target-text">
  私は以前の職場ではシステムを使用する側にあり、システムを使用することで時間や場所に制限なくより効率的に業務ができると感じておりました。今後はITの基礎知識やプログラミング言語に対する知識を深め、基本情報処理試験の資格取得を目指しながら、システムを制作する一員として携わり、生活で役立つシステムを当たり前のように使用できるサービスを私もエンジニアとして提供できるようになりたいと考えております。
  </p>
</div>
 <!-- 将来像 -->

<!-- 経歴フレックス   -->
<div class="keireki-wrapper">
<h2 class="media-title">− プログラマーを目指してから現在まで −</h2>
<div class="keireki-flex">
  <div class="yajirusi">
    <div class="bar"></div>
    <div class="triangle"></div>
  </div>
  <div class="keireki">
    <p class="date">令和3年12月</p>
    <div class="item">
    <p class="item-text">
      ITの基礎知識を身につけるためにITパスポート取得に向けて勉強を行う。
    </p>
    </div>
    <p class="date">令和4年2月</p>
    <div class="item">
    <p class="item-text">
      ITパスポート試験取得
    </p>
    </div>
    <p class="date">令和4年2月</p>
    <div class="item">
    <p class="item-text">
      ITパスポートだけでは就職するには不十分と考え、基本情報技術者試験のために勉強を行う。
    </p>
    </div>
    <p class="date">令和4年3月</p>
    <div class="item">
    <p class="item-text">
      資格取得のための勉強と並行してドットインストール(プログラミング学習サービス)でHTML、CSS、Pythonの独学を始める。
    </p>
    </div>
    <p class="date">令和4年5月20日</p>
    <div class="item">
      <p class="item-text">
        職業訓練校</br>FOREVER　ITプログラマー養成科入学
      </p>
      </div>
    
  </div>
</div>
</div>
<!-- 経歴フレックス -->

<!-- スキル -->
<h2 id="skill">− スキル −</h2>
  <p class="OS">OS</p>
  <div class="grid">
    <div class="icon">
      <img src="images/icons8-0-144.png">
      <p>Windows</p>
    </div>
    <div class="icon">
      <img src="images/icons8-mac-os-150.png">
      <p>Mac</p>
    </div>
  </div>
  <p class="language">言語</p>
  <div class="grid">
      <div class="icon">
        <img src="images/icons8-html-5-144.png">
        <p>HTML</p>
      </div>
    <div class="icon">
    <img src="images/icons8-css3-144.png">
    <p>CSS</p>
    </div>
    <div class="icon">
    <img src="images/php.png">
    <p>PHP</p>
    </div>
    <div class="j-icon icon">
    <img src="images/javascript.png">
    <p>JavaScript</p>
    <p>(初歩レベル)</p>
    </div>
    <div class="icon">
    <img src="images/python.png">
    <p>python</p>
    <p>(初歩レベル)</p>
    </div>
  </div>

<!-- 作品 -->
<div class="work-wrapper">
  <h2 id="work">− 作品 −</h2>
  <div class="works">
    <div class="hospital-wrapper">
      <a href="hospital/index.html"><img src="hospital/images/hospital5.jpg" alt="" class="link-hospital"></a>
      <h3><a href="hospital/index.html">菊池耳鼻咽喉科</a></h3>

      <script src="https://code.jquery.com/jquery.min.js"></script>
      <script>
        $(function() {
            $(".exple-a").click(function() {
                $(".exple-b").toggleClass("exple-c");
            });
        });
      </script>
      <h4 class="exple-a">サイト説明</h4>
      <p class="exple-b">予約システムがある病院のHPを作成しました。エラーのパターンを複数考えながら、エラーがある際は分かりやすく表示されるようにこだわりながら作成しました。予約すると診察番号を取得し、現在の待ち状況が分かるように作成しています。現在のところ、病院のホームページとは別に、診察完了した診察番号の情報を受付が操作する用に<a href="hospital/reception/reseption_login.php">別ページ</a>(パスワード:0000)を用意しています。<br>今後の課題として、この予約システムに連動して、診察が終わり次第自動でデータベースの情報を書き換えるシステムもあればさらに実用的になると考えています。</p>
      <p>サイト制作期間：3週間</p>
      <p>使用言語:HTML CSS PHP</p>
    </div>
    <div class="post-wrapper">
      <a href="post/login.php"><img src="images/post.png" alt=""></a>
      <h3><a href="post/login.php">投稿掲示板</a></h3>
      <script>
        $(function() {
            $(".exple-d").click(function() {
                $(".exple-e").toggleClass("exple-c");
            });
        });
      </script>
      <h4 class="exple-d">サイト説明</h4>
      <p class="exple-e">ログイン機能のある投稿掲示板を作成しました。コメントに返信できるようにして、掲示板を利用する人がやり取りをしやすいようにこだわりながら作成しました。</p>
      <p>サイト制作期間：2週間</p>
      <p>使用言語:HTML CSS PHP</p>
    </div>

    <div class="portfolio-wrapper">
      <a href=""><img src="images/portfolio.png" alt=""></a>
      <h3><a href="post/login.php">ポートフォリオ</a></h3>
      <script>
        $(function() {
            $(".exple-g").click(function() {
                $(".exple-h").toggleClass("exple-c");
            });
        });
      </script>
      <h4 class="exple-g">サイト説明</h4>
      <p class="exple-h">私自身のポートフォリオを作成しました。見る人ができるだけ分かりやすく、見やすくを意識して作成しました。PHPでメール送信機能も装備してあります。JavaScriptでハンバーガーメニューを作成した点では時間はかかりましたが、JavaScriptの知識を深めることができました。</p>
      <p>サイト制作期間：10日間</p>
      <p>使用言語:HTML CSS PHP JavaScript</p>
    </div>

  </div>
</div>

</div>
<!-- お試しお問い合わせフォーム -->
<h2 class="page-title" id="contact">Contact</h2>
<!-- actionでsubmitが実行された時の送信先ページを指定 -->
<?php if ($err_msg != ''): ?>
  <div class="alert alert-danger">
    <?php echo $err_msg; ?>
  </div>
  <?php endif; ?>
  
  <?php if ($complete_msg != ''): ?>
    <div class="alert alert-success">
      <?php echo $complete_msg; ?>
    </div>
    <?php endif; ?>
    
    <form method="post">
  <div>
    <label form="name">お名前</label>
    <input type="text" name="name" placeholder="お名前" value="<?php echo $name; ?>">
  </div>
  <div>
    <label form="email">メールアドレス</label>
    <input type="text" name="email" placeholder="メールアドレス" value="<?php echo $email; ?>">
  </div>
  <div>
    <label form="name">件名</label>
    <input type="text" name="subject" placeholder="件名" value="<?php echo $subject; ?>">
  </div>
  <div>
  <div class="contact2">
    <label form="message" >メッセージ</label>
    <textarea name="message" placeholder="本文"><?php echo $message; ?></textarea>
  </div>
  <button type="submit" class="button">送信</button>
</form>
<script src="js/main.js"></script>
</body>
</html>
