<?php
session_start();
error_reporting(0);
include_once 'safemode.php';
$trade_no = trim(htmlspecialchars($_REQUEST['out_trade_no'])); //接收订单号
$optEmail = "MSVOD魅思视频系统"; //收款人的账号 用于显示在页面上
$cny = (float) trim(htmlspecialchars($_REQUEST['total_fee'])); //付款金额
$type = trim(htmlspecialchars($_REQUEST['pay'])); //支付方式
$key = "14816880201740"; //支付KEY12位的APPID
$mobile = trim(htmlspecialchars($_REQUEST['mobile'])); //递值
if ($type == 1) {
	$typename = "支付宝扫码";}
if ($type == 2) {
	$typename = "财付通扫码";}
if ($type == 3) {
	$typename = "微信扫码";}
if ($type <= 3) {
	require_once "appapiewm.php";
}

?>
<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>
扫码支付 - 网上支付 安全快速！
</title>
<script src="css/jquery.min.js"></script>
<link charset="utf-8" rel="stylesheet" href="css/api.css" media="all">
<script type="text/javascript">
var intDiff = parseInt(300);
function timer(intDiff){
window.setInterval(function(){
var day=0,
hour=0,
minute=0,
second=0;
if(intDiff > 0){
day = Math.floor(intDiff / (60 * 60 * 24));
hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
}
if (minute <= 9) minute = '0' + minute;
if (second <= 9) second = '0' + second;
$('#day_show').html(day+"天");
$('#hour_show').html('<s id="h"></s>'+hour+'时');
$('#minute_show').html('<s></s>'+minute+'分');
$('#second_show').html('<s></s>'+second+'秒');
if(intDiff==0){
//self.location=document.referrer;
self.location.href="/user/pay";
}
intDiff--;
}, 1000);
}
$(function(){
timer(intDiff);
});
</script>
</head>
<body>
<div class="topbar">
<div class="topbar-wrap fn-clear">
<a href="https://help.alipay.com/lab/help_detail.htm?help_id=258086" class="topbar-link-last" target="_blank" seed="goToHelp">常见问题</a>
<span class="topbar-link-first">你好，欢迎使用扫码付款！</span>
</div>
</div>
<div id="header">
<div class="header-container fn-clear">
<div class="header-title">
<div class="<?php echo $logo; ?>">
</div>
<span class="logo-title">
我的收银台
</span>
</div>
</div>
</div>
<div id="container">
<div id="content" class="fn-clear">
<div id="J_order" class="order-area">
<div id="order" class="order order-bow">
<div class="orderDetail-base">
<div class="commodity-message-row">
<span class="first long-content">
会员ID/订单号：<?php echo $trade_no; ?></span>&nbsp;&nbsp;(本次交易将直达收款方账户)
<span class="second short-content">
收款方：<?php echo $optEmail; ?>&nbsp;
</span>
</div>
<span class="payAmount-area" id="J_basePriceArea">
<strong class=" amount-font-22 "><?php echo $cny; ?></strong> 元
</span>
</div>
</div>
</div>
<!-- 操作区 -->
<div class="cashier-center-container">
<div data-module="excashier/login/2015.08.02/loginPwdMemberT" id="J_loginPwdMemberTModule" class="cashiser-switch-wrapper fn-clear">
<!-- 扫码支付页面 -->
<div class="cashier-center-view view-qrcode fn-left" id="J_view_qr">
<!-- 扫码区域 -->
<div data-role="qrPayArea" class="qrcode-integration qrcode-area" id="J_qrPayArea">
<div class="qrcode-header">
<div class="ft-center">
扫一扫付款<?php echo $cny; ?>（元）                  </div>
<div class="ft-center qrcode-header-money"><?php echo $cny; ?></div>
</div>
<div class="qrcode-img-wrapper" id="payok">
<font>
<img class="ft-center" width="168" height="168" src="pic.php?path=<?php echo $ewm; ?>"></font>
<input name="payAmount" id="payAmount" value="<?php echo $cny; ?>" type="hidden">
<input name="title" id="title" value="<?php echo $trade_no; ?>" type="hidden">
<input name="APPID" id="APPID" value="<?php echo $key; ?>" type="hidden">
<input name="type" id="type" value="<?php echo $type; ?>" type="hidden">
<input name="beizhu" id="beizhu" value="<?php echo $_SESSION['beizhu']; ?>" type="hidden">
<div class="qrcode-img-explain fn-clear">
<img class="fn-left" src="css/T1bdtfXfdiXXXXXXXX.png" alt="扫一扫标识">
<div class="fn-left"><font id="zt">打开<?php echo $qrna; ?></font><br><strong id="minute_show"><s></s>04分</strong>
<strong id="second_show"><s></s>44秒</strong>过期</div>
</div>
</div>
<br>
<a href="<?php echo $uourldown; ?>" class="qrcode-downloadApp">首次使用请下载<?php echo $qrna; ?></a>
</div>
<!-- 指引区域 -->
<div class="qrguide-area">
<img src="<?php echo $qr; ?>" class="qrguide-area-img active">              </div>
</div>
</div>
</div>
</div>
</div>
<div id="partner"><br><p>本站为第三方辅助软件服务商，与支付宝官方和淘宝网无任何关系，本支付系统拒绝违法网站使用 <br>收支宝支付系统 不提供资金托管和结算，转账后将立即到达指定的账户。</p>
<br><img alt="合作机构" src="css/2R3cKfrKqS.png"></div>
</body>
</html>
<?php
$types = "add_balance";
$custom2 = "approved";
$custom6 = 1;
mysqli_query($conn, "SET NAMES 'UTF8'");
$sqlurl = "SELECT * FROM `ewmadmin` WHERE `appid`='{$key}' and `type`='{$types}' and fkok=1 and `custom2`='{$custom2}' and `custom6`='{$custom6}' order by id asc ";
$urlhistory = mysqli_fetch_assoc(mysqli_query($conn, $sqlurl));
$httpurls = $urlhistory['urls'];
$urlbak = $urlhistory['jiekou'];
$urlok = "http://" . $urlbak;
?>
<script type="text/javascript">
$(function(){
var posTimmer;
var $win = $(window);
var $submit = $('#submit');
setInterval(function(){
$.ajax({
url:"zidong.php",
type: "post",
timeout:2000,
data: {tradeNo:$("#title").val(),payAmount:$("#payAmount").val(),APPID:$("#APPID").val(),paytype:$("#type").val(),beizhu:$("#beizhu").val()},
success: function(d){
if(d == "success" ){
$submit.text('付款成功');
setTimeout(function(){
if ( 0 ) {
location.replace("<?php echo $urlok; ?>/user/pay/lists");
} else {
if (window.opener) {
location.replace("<?php echo $urlok; ?>/user/pay/lists");
} else {
location.replace("<?php echo $urlok; ?>/user/pay/lists");
}
}
},5000);
}
}
});
},5000);
$('#msgPayForm').submit();
});
</script>
<?php
if ($ewm == "ali.png") {
	echo "<script language='javascript'> ";
	echo "alert('暂时无二维码，请稍等后在支付');";
	echo "</script>";

	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='/user/pay'";
	echo "</script>";

//echo "暂时无二维码，请稍等后在测试";";
	exit();
}
if ($mobile == 2) {
	echo "<script language='javascript' type='text/javascript'>";
	echo "window.location.href='" . $_SESSION['ewmurl'] . "'";
	echo "</script>";
}
?>
