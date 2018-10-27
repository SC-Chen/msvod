<?php
include_once "../msvod/lib/Ms_DB.php";
//配置MYSQL数据库连接信息
$mysqli_server_name = MS_Sqlserver; //数据库服务器名称
$mysqli_username = MS_Sqluid; // 连接数据库用户名
$mysqli_password = MS_Sqlpwd; // 连接数据库密码
$mysqli_database = MS_Sqlname; // 数据库的名字
$mysqli_conn = mysqli_connect($mysqli_server_name, $mysqli_username, $mysqli_password);
?>
