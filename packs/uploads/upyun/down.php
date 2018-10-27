<?php
@header('Content-Type: text/html; charset=gbk');
require_once('upyun.class.php');
require_once('../../../msvod/lib/Ms_Upyun.php');
$uri = $_SERVER["REQUEST_URI"];
$code = explode("down.php",$uri);
$path = explode("?size",$code[1]);
$upyun = new UpYun(MS_Upy_Bucket, MS_Upy_Name, MS_Upy_Pwd);
header('Content-type: application/force-download');
echo $upyun->readFile($path[0]);
