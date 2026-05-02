<?php

$pdo = new PDO("mysql:host=localhost;dbname=hp_site;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>