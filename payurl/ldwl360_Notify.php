<?php
include_once "config.php";
include_once "../msvod/lib/Ms_User.php";
if ($mysqli_conn) {
	mysqli_select_db($mysqli_conn, $mysqli_database);
	mysqli_query($mysqli_conn, "SET NAMES 'UTF8'"); //消除乱码
	//-----------------------------------------------------------------
	//-----------------------------------------------------------------
	//开始接收参数 (请注意区分大小写)
	//-----------------------------------------------------------------
	$payNO = isset($_REQUEST["PayNO"]) ? $_REQUEST["PayNO"] : ""; //支付宝的订单号码
	$Money2 = isset($_REQUEST["PayJe"]) ? $_REQUEST["PayJe"] : 0; //付款金额
	$Money = floatval($Money2);
	$dingdannum = isset($_REQUEST["PayMore"]) ? $_REQUEST["PayMore"] : ""; //付款说明
	$key = isset($_REQUEST["key"]) ? $_REQUEST["key"] : ""; //签名
	$key2 = 990294; // 改成自己的秘钥 在U支付网站平台会员中心页面

	$bjsnk = strcmp($key2, $key);

//-----------------------------------------------------------------
	if ($bjsnk === 0) {
/***第一步判断 支付记录  收款单  的存在*****************************************************************/
		$status = 0;
		$rs = mysqli_query($mysqli_conn, "Select * From ms_pay Where dingdan='$dingdannum' and cion='$Money' and pid='$status'"); //查找订单号
		$num = mysqli_num_rows($rs);
		if ($num > 0) {
			$dingdanok = true; //订单存在
			//echo "订单存在<br>";
		} else {
			$dingdanok = false; //订单不存在
			//echo "订单不存在<br>";
			//ob_clean();
			//echo "Error";
		}
		if ($dingdanok == true) {
			$sql = "select * from ms_pay where  dingdan='" . $dingdannum . "' and cion='$Money' ";
			$query = mysqli_query($mysqli_conn, $sql);
			$rs = mysqli_fetch_array($query);
			$uuid = $rs['uid']; // 用户UID
			$payid = $rs['id']; // 订单id

/*代理提成*/
			$row = mysqli_fetch_array(mysqli_query($mysqli_conn, "select * from ms_user where id='" . $uuid . "'"));
			if ($row['dlid'] > 0) {
				$ciony = User_Cion_tichengy * $Money / 100;
				mysqli_query($mysqli_conn, "INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $row['dlid'] . "','1','" . $ciony . "','" . time() . "')");
				mysqli_query($mysqli_conn, "Update ms_user set zjcion=zjcion+'$ciony' Where id='" . $row['dlid'] . "'"); //一级代理提成更新
				$rowy = mysqli_fetch_array(mysqli_query($mysqli_conn, "select * from ms_user where id='" . $row['dlid'] . "'"));
				if ($rowy['dlid'] > 0) {
					$cione = User_Cion_tichenge * $Money / 100;
					mysqli_query($mysqli_conn, "INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $rowy['dlid'] . "','2','" . $cione . "','" . time() . "')");
					$rows = mysqli_fetch_array(mysqli_query($mysqli_conn, "select * from ms_user where id='" . $rowy['dlid'] . "'"));
					mysqli_query($mysqli_conn, "Update ms_user set zjcion=zjcion+'$cione' Where id='" . $rowy['dlid'] . "'"); //二级代理提成更新
					if ($rows['dlid'] > 0) {
						$cions = User_Cion_tichengs * $Money / 100;
						mysqli_query($mysqli_conn, "INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $rows['dlid'] . "','3','" . $cions . "','" . time() . "')");
						mysqli_query($mysqli_conn, "Update ms_user set zjcion=zjcion+'$cions' Where id='" . $rows['dlid'] . "'"); //三级代理提成更新
					}
				}
			}
//echo $uuid;

			mysqli_query($mysqli_conn, "Update ms_user set cion=cion+'$Money' Where id='" . $uuid . "'"); //更新会员余额
			mysqli_query($mysqli_conn, "Update ms_pay set pid=1 Where id='" . $payid . "'"); //更新订单ID
			ob_clean();
			echo "Success"; //此处返回值（Success）不能修改，当检测到此字符串时，就表示充值成功
		}
	} else {
		echo "Key"; //钥匙不正确
	}
//*******************************************************************
	mysqli_close($mysqli_conn);
} else {
	echo "Errordb"; //连接数据库失败
}
//*******************************************************************
?>
