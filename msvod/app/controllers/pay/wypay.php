<?php 
/**
 * @Mscms 4.x open source management system
 * @copyright 2009-2015 msvod.cc. All rights reserved.
 * @Author:Msvod QQ:487039015
 * @Dtime:2015-04-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wypay extends Msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjUser');
			$this->lang->load('pay');
	}

    //请求支付
	public function index()
	{
            $this->MsdjUser->User_Login();
		    $id=(int)$this->uri->segment(4); //订单ID
			echo $id;
			//exit();
            if($id==0)  msg_url(L('pay_01'),spacelink('pay'));
            $row=$this->MsdjDB->get_row('pay','*',$id);
			//if(!$row || $row->uid!=$_SESSION['mscms__id']){
            //     msg_url(L('pay_02'),spacelink('pay'));
			//}

            $v_amount    = $row->rmb;
            $v_moneytype = 'CNY';
            $v_oid       = $row->dingdan;
            $v_mid       = CS_Wypay_ID;
            $v_url       = site_url('pay/wypay/return_url');
		    $v_url2      = "[url:=".site_url('pay/wypay/notify_url')."]";
            $key         = CS_Wypay_Key;
            $text        = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$key;
            $md5info     = strtoupper(md5($text));

            echo '
	        <form method="post" id="form1" name="form1" action="/ldpay/apppay.php">
	        <input type="hidden" name="v_mid" value="'.$v_mid.'">
	        <input type="hidden" name="v_oid" value="'.$v_oid.'">
	        <input type="hidden" name="v_amount" value="'.$v_amount.'">
	        <input type="hidden" name="v_moneytype" value="'.$v_moneytype.'">
	        <input type="hidden" name="v_url" value="'.$v_url.'">
	        <input type="hidden" name="remark2" value="'.$v_url2.'">
	        <input type="hidden" name="v_md5info" value="'.$md5info.'">
	        </form><script language="javascript">document.form1.submit();</script>';
	}


}
