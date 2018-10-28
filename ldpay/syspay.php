锘??php
include_once 'config.php';
$dingdan = $_GET["out_trade_no"]; //璁㈠崟鍙?
$jiage = $_GET["total_fee"]; //鏀粯閲戦
$mobile = "0"; //闇€璁剧疆0
$paytype = "1";

$status = 0;
$rs = mysqli_query($conn, "Select * From ms_pay Where dingdan='$dingdan' and pid='$status'"); //鏌ユ壘璁㈠崟鍙?
$num = mysqli_num_rows($rs);
if ($num > 0) {
	$dingdanok = true;
} else {
	$dingdanok = false;
	echo "Error";
}
if ($dingdanok == true) {
	$sql = "select * from ms_pay where dingdan='" . $dingdan . "'";
	$query = mysqli_query( $conn,$sql);
	$rs = mysqli_fetch_array($query);
	$jiage = $rs['cion'];
}

?>
<div style="text-align:center;">
<form name="form"  id="payment" accept-charset="UTF-8" action="alipay.php" method="post" >
<input name="out_trade_no" id="out_trade_no"  type="hidden" value="<?php echo $dingdan ?>" />
<input name="seller_email" id="seller_email"  type="hidden" value="<?php echo $seller_email ?>" />
<input name="total_fee" id="total_fee"  type="hidden" value="<?php echo $jiage ?>" />
<input name="pay" id="pay"  type="hidden" value="<?php echo $paytype ?>" />
<input name="appid" id="appid"  type="hidden" value="<?php echo $appid ?>" />
<input name="mobile" id="mobile"  type="hidden" value="<?php echo $mobile ?>" />
<input type="submit" class="ui-btn"  onclick="javascript:document.charset='UTF-8';document.getElementById('payment').submit()"  value="hide" style="display:none" align="left" />
</form><script>document.forms['payment'].submit();</script>
