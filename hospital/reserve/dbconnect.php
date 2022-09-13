<?php
    
    $dsn = 'mysql:dbname=LAA1435269-mydb;host=mysql205.phy.lolipop.lan;charset=utf8';
    $usr = 'LAA1435269';
    $passwd = 'eqje';

    try{
      $db = new PDO($dsn, $usr, $passwd);
    } catch (PDOExceprion $e) {
      print "DB接続エラー：{$e->getMessage()}";
    }

?>