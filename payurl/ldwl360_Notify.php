<?php
include_once "config.php";
include_once "../msvod/lib/Ms_User.php";
if ($mysqli_conn) {
	mysqli_select_db($mysqli_conn, $mysqli_database);
	mysqli_query($mysqli_conn, "SET NAMES 'GBK'"); //��������
	//-----------------------------------------------------------------
	//-----------------------------------------------------------------
	//��ʼ���ղ��� (��ע�����ִ�Сд)
	//-----------------------------------------------------------------
	$payNO = isset($_REQUEST["PayNO"]) ? $_REQUEST["PayNO"] : ""; //֧�����Ķ�������
	$Money2 = isset($_REQUEST["PayJe"]) ? $_REQUEST["PayJe"] : 0; //������
	$Money = floatval($Money2);
	$dingdannum = isset($_REQUEST["PayMore"]) ? $_REQUEST["PayMore"] : ""; //����˵��
	$key = isset($_REQUEST["key"]) ? $_REQUEST["key"] : ""; //ǩ��
	$key2 = 990294; // �ĳ��Լ�����Կ ��U֧����վƽ̨��Ա����ҳ��

	$bjsnk = strcmp($key2, $key);

//-----------------------------------------------------------------
	if ($bjsnk === 0) {
/***��һ���ж� ֧����¼  �տ  �Ĵ���*****************************************************************/
		$status = 0;
		$rs = mysqli_query($mysqli_conn, "Select * From ms_pay Where dingdan='$dingdannum' and cion='$Money' and pid='$status'"); //���Ҷ�����
		$num = mysqli_num_rows($rs);
		if ($num > 0) {
			$dingdanok = true; //��������
			//echo "��������<br>";
		} else {
			$dingdanok = false; //����������
			//echo "����������<br>";
			//ob_clean();
			//echo "Error";
		}
		if ($dingdanok == true) {
			$sql = "select * from ms_pay where  dingdan='" . $dingdannum . "' and cion='$Money' ";
			$query = mysqli_query( $mysqli_conn,$sql);
			$rs = mysqli_fetch_array($query);
			$uuid = $rs['uid']; // �û�UID
			$payid = $rs['id']; // ����id

/*�������*/
			$row = mysqli_fetch_array(mysqli_query( $mysqli_conn,"select * from ms_user where id='" . $uuid . "'"));
			if ($row['dlid'] > 0) {
				$ciony = User_Cion_tichengy * $Money / 100;
				mysqli_query($mysqli_conn,"INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $row['dlid'] . "','1','" . $ciony . "','" . time() . "')");
				mysqli_query($mysqli_conn,"Update ms_user set zjcion=zjcion+'$ciony' Where id='" . $row['dlid'] . "'"); //һ��������ɸ���
				$rowy = mysqli_fetch_array(mysqli_query( $mysqli_conn,"select * from ms_user where id='" . $row['dlid'] . "'"));
				if ($rowy['dlid'] > 0) {
					$cione = User_Cion_tichenge * $Money / 100;
					mysqli_query($mysqli_conn,"INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $rowy['dlid'] . "','2','" . $cione . "','" . time() . "')");
					$rows = mysqli_fetch_array(mysqli_query( $mysqli_conn,"select * from ms_user where id='" . $rowy['dlid'] . "'"));
					mysqli_query($mysqli_conn,"Update ms_user set zjcion=zjcion+'$cione' Where id='" . $rowy['dlid'] . "'"); //����������ɸ���
					if ($rows['dlid'] > 0) {
						$cions = User_Cion_tichengs * $Money / 100;
						mysqli_query($mysqli_conn,"INSERT INTO `ms_daili_jilu`(`uid`, `dlid`, `dljb`, `cion`,`dltime`) VALUES ('" . $uuid . "','" . $rows['dlid'] . "','3','" . $cions . "','" . time() . "')");
						mysqli_query($mysqli_conn,"Update ms_user set zjcion=zjcion+'$cions' Where id='" . $rows['dlid'] . "'"); //����������ɸ���
					}
				}
			}
//echo $uuid;

			mysqli_query($mysqli_conn,"Update ms_user set cion=cion+'$Money' Where id='" . $uuid . "'"); //���»�Ա���
			mysqli_query($mysqli_conn,"Update ms_pay set pid=1 Where id='" . $payid . "'"); //���¶���ID
			ob_clean();
			echo "Success"; //�˴�����ֵ��Success�������޸ģ�����⵽���ַ���ʱ���ͱ�ʾ��ֵ�ɹ�
		}
	} else {
		echo "Key"; //Կ�ײ���ȷ
	}
//*******************************************************************
	mysqli_close($mysqli_conn);
} else {
	echo "Errordb"; //�������ݿ�ʧ��
}
//*******************************************************************
?>
