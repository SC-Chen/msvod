<?php
#数据库连接
include_once 'config.php';
$conn = mysqli_connect($host, $user, $password) or die("连接超时~请重试");
mysqli_select_db($conn, $db);
mysqli_query($conn, "set names utf8");
date_default_timezone_set("Asia/Shanghai");
?>
