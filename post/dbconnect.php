<?php
    
    $dsn = 'mysql:dbname=LAA1435269-tometome;host=mysql206.phy.lolipop.lan;charset=utf8';
    $usr = 'LAA1435269';
    $passwd = 'eB63x';

    try{
      $db = new PDO($dsn, $usr, $passwd);
    } catch (PDOExceprion $e) {
      print "DB接続エラー：{$e->getMessage()}";
    }

?>