<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-10
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kqpay extends msvod_Controller {

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
            echo L('pay_18');
	}

	//同步返回
	public function return_url()
	{
            $this->MsdjUser->User_Login();
	}

	//异步返回
	public function notify_url()
	{

	}
}
