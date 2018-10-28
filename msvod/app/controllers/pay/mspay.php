<?php 
/**
 * @msvod 4.x open source management system
 * @copyright 2009-2015 msvod.cc. All rights reserved.
 * @Author:Cheng Jie
 * @Dtime:2015-04-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mspay extends msvod_Controller {

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
            if($id==0)  msg_url(L('pay_01'),spacelink('pay'));
            $row=$this->MsdjDB->get_row('pay','*',$id);
			if(!$row || $row->uid!=$_SESSION['msvod__id']){
                 msg_url(L('pay_02'),spacelink('pay'));
			}
	  		$pay_url		 = 'http://pay.msvod.cc/pay';		        /* MSPAY支付请求地址 */
	  		$pay_sid		 = '1';			/* 交易方式，业务代码，1为支付宝，2为微信支付，3为网银 */
	  		$pay_mode		 = '';
      		$body			 = L('pay_03',array($_SESSION['msvod__name']));    /* 商品名 */	
	  		$out_trade_no	 = $row->dingdan;                        /* 商户订单号*/       		 
      		$total_fee	     = $row->rmb;			                /* 总金额 */
	  		$partner		 = MS_Mspay_ID;        /* 商户号 */	
	  		$key			 = MS_Mspay_Key;			/* 商户加密key */      
      		$return_url	     = site_url('pay/mspay/return_url');			/* 同步返回地址 */
	  		$notify_url	     = site_url('pay/mspay/notify_url');			/* 异步返回地址 */
      		$remark          = '';                                /* 自定义字段 */

      		/* 数字签名 */
      		$sign_text = "pay_sid=" . $pay_sid . "&out_trade_no=" . $out_trade_no . "&total_fee=" . intval($total_fee) .
                   "&partner=" . $partner . "&key=" . $key .  "&return_url=" . $return_url . "&notify_url=" . $notify_url;

      		$sign = strtoupper(md5($sign_text));
      		/* 交易参数 */
      		$parameter = array(
            'charset'                   => 'gbk',  
            'pay_sid'                   => $pay_sid,            
            'body'                      => $body,                      
            'out_trade_no'              => $out_trade_no,   
            'total_fee'                 => $total_fee,              
            'partner'                   => $partner,		         
            'return_url'                => $return_url,		
            'notify_url'                => $notify_url,                  
            'remark'                    => $remark,                  
            'sign'                      => $sign                         
      		);
      		$button  = '<form name="CsPayForm" method="post" style="text-align:left;" action="' . $pay_url . '" style="margin:0px;padding:0px" >';
      		foreach ($parameter AS $key=>$val)
      		{
          		$button  .= "<input type='hidden' name='$key' value='$val'/>";
      		}
	  		$formstr = $button . '</form><script>document.CsPayForm.submit();</script>';
	  		echo $formstr;
	}

	//同步返回
	public function return_url()
	{
            $this->MsdjUser->User_Login();
	        /*取返回参数*/
            $mspay_id        = intval($this->input->get('mspay_id',TRUE));        //MSPAY交易号
            $mspay_pid       = intval($this->input->get('mspay_pid',TRUE));       //MSPAY交易结果
            $pay_sid     	 = intval($this->input->get('pay_sid',TRUE));         //交易方式，业务代码
            $out_trade_no    = $this->input->get('out_trade_no',TRUE,TRUE);    //定单号
            $total_fee   	 = $this->input->get('total_fee',TRUE,TRUE);       //金额
            $remark	 	 	 = $this->input->get('remark',TRUE,TRUE);          //自定义字段
            $sign            = $this->input->get('sign',TRUE,TRUE);            //加密数字签名
	        $partner		 = MS_Mspay_ID;                    	
	        $key			 = MS_Mspay_Key;			    
            $return_url		 = site_url('pay/mspay/return_url');			
	        $notify_url		 = site_url('pay/mspay/notify_url');			
		
            /* 检查数字签名是否正确 */
            $sign_text = "mspay_id=". $mspay_id ."&mspay_pid=". $mspay_pid ."&pay_sid=" . $pay_sid . "&out_trade_no=" . $out_trade_no . "&total_fee=" . $total_fee .
                     "&partner=" . $partner . "&key=" . $key .  "&return_url=" . $return_url . "&notify_url=" . $notify_url;
            $sign_md5 = strtoupper(md5($sign_text));
            //支付状态验证
            if ($sign_md5 == $sign && $mspay_pid==1){  //验证支付成功
				   $row=$this->MsdjDB->get_row('pay','*',$out_trade_no,'dingdan');
				   if($row && $row->pid!=1){
                        //增加金钱
						$this->db->query("update ".MS_SqlPrefix."user set rmb=rmb+".$row->rmb." where id=".$row->uid."");
						//改变状态
						$this->db->query("update ".MS_SqlPrefix."pay set pid=1 where id=".$row->id."");
						//发送通知
						$add['uida']=$row->uid;
						$add['uidb']=0;
						$add['name']=L('pay_11');
						$add['neir']=L('pay_17',array($row->rmb,$out_trade_no));
						$add['addtime']=time();
            			$this->MsdjDB->get_insert('msg',$add);
				   }
                   msg_url(L('pay_07').$out_trade_no,spacelink('pay'));
			} else {  //验证支付失败
                   msg_url(L('pay_09'),spacelink('pay'));
			}
	}

	//异步返回
	public function notify_url()
	{
	        /*取返回参数*/
            $mspay_id        = intval($this->input->post('mspay_id',TRUE));        //MSPAY交易号
            $mspay_pid       = intval($this->input->post('mspay_pid',TRUE));       //MSPAY交易结果
            $pay_sid     	 = intval($this->input->post('pay_sid',TRUE));         //交易方式，业务代码
            $out_trade_no    = $this->input->post('out_trade_no',TRUE,TRUE);    //定单号
            $total_fee   	 = $this->input->post('total_fee',TRUE,TRUE);       //金额
            $remark	 	 	 = $this->input->post('remark',TRUE,TRUE);          //自定义字段
            $sign            = $this->input->post('sign',TRUE,TRUE);            //加密数字签名
	        $partner		 = MS_Mspay_ID;                    	
	        $key			 = MS_Mspay_Key;			    
            $return_url		 = site_url('pay/mspay/return_url');			
	        $notify_url		 = site_url('pay/mspay/notify_url');			
		
            /* 检查数字签名是否正确 */
            $sign_text = "mspay_id=". $mspay_id ."&mspay_pid=". $mspay_pid ."&pay_sid=" . $pay_sid . "&out_trade_no=" . $out_trade_no . "&total_fee=" . $total_fee .
                     "&partner=" . $partner . "&key=" . $key .  "&return_url=" . $return_url . "&notify_url=" . $notify_url;
            $sign_md5 = strtoupper(md5($sign_text));
            if ($getmspay != 'ok') {  //支付状态检测
				echo "NO";
			}else{
				if ($sign_md5 == $sign && $mspay_pid==1){
				   $row=$this->MsdjDB->get_row('pay','*',$out_trade_no,'dingdan');
				   if($row && $row->pid!=1){
                        //增加金钱
						$this->db->query("update ".MS_SqlPrefix."user set rmb=rmb+".$row->rmb." where id=".$row->uid."");
						//改变状态
						$this->db->query("update ".MS_SqlPrefix."pay set pid=1 where id=".$row->id."");
						//发送通知
						$add['uida']=$row->uid;
						$add['uidb']=0;
						$add['name']=L('pay_11');
						$add['neir']=L('pay_17',array($row->rmb,$out_trade_no));
						$add['addtime']=time();
            			$this->MsdjDB->get_insert('msg',$add);
				   }
				   echo "OK";
				}else{
				   echo "NO";
				}
			}
	}

    //远程查询交易结果
	public function get_mspayurl($mspay_id){
        if(empty($mspay_id)) return '';
        $url = "http://pay.msvod.cc/pay/notify_query?key=".MS_Mspay_Key."&mspay_id=".$mspay_id;
        $FileContent=@file_get_contents($url);
        if(empty($FileContent)){
           $ch = curl_init($url);
           curl_setopt($ch, CURLOPT_TIMEOUT, 1);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           $FileContent = curl_exec($ch);
           curl_close ($ch);
        }
        return $FileContent;
	}
}
