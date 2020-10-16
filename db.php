<?php
	$pdo = new PDO("mysql:dbname=kopyasozluk_rec;charset=utf8", "root");
	$db  = new NotORM($pdo);
	$db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
	
?>
