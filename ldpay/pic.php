<?php
error_reporting(0);
if(count($_GET)>0)
{
    $_SESSION['HTTP_REFERER']=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"";
    function CheckURL()
    {
        if($_SESSION['HTTP_REFERER']=="")
        {
            header("location:/index.php");
            exit;
        }
    }
    CheckURL();
}
include_once 'safemode.php';
$path=$_GET["path"];
$cacheimgname =str_replace("/","_",$path);
$localimg="testimg/".$cacheimgname;

if((file_exists($localimg)))
{
$httpurl=$localimg;
}
else{
$httpurl="/ewmadmin/ewmimages/2017ewmuzhifu/".$path;
@copy($httpurl,$localimg);
}
header("Location:$httpurl");
exit;
?>
