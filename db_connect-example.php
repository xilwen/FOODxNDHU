<?php
$db_host = "localhost";
$db_user = "";
$db_password = "";
$db_name = "";
$db_link = @mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$db_link) die("資料庫無法連線，錯誤："  . mysqli_connect_error());
mysqli_query($db_link,"SET NAMES 'utf8'");
?>