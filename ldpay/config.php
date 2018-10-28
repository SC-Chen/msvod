<?php
error_reporting(0);
session_start();
include_once "../msvod/lib/Ms_DB.php";
include_once "../msvod/lib/Ms_Pay.php";
header("Content-type:text/html;charset=utf-8");
$aa = MS_Sqlserver; //数据库连接地址
$bb = MS_Sqluid; //数据库用户名
$cc = MS_Sqlpwd; //数据库密码
$dd = MS_Sqlname; //数据库名称
$appid = MS_Alipay_Key; //appid 需要改成你的
$seller_email = "视频"; //改成你的网站名称 或者收款账号 或者收款人姓名等等
$payali = "ali.png"; //默认支付宝二维码 请不要修改
$payten = "ten.png"; //默认财付通二维码 请不要修改
$paywx = "wx.png"; //默认微信二维码 请不要修改
$conn = mysqli_connect($aa, $bb, $cc);
if (mysqli_select_db($conn, $dd)) {
} else {
	echo "数据库连接失败！";
}
mysqli_query($conn, "set names 'utf8'");
