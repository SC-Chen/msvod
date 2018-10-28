<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-11-23
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->lang->load('user');
	}

    //退出登录
	public function index()
	{
            //删除在线状态
            $updata['zx']=0;
			if(isset($_SESSION['msvod__id'])){
                $this->MsdjDB->get_update('user',$_SESSION['msvod__id'],$updata);
				$this->MsdjDB->get_del('session',$_SESSION['msvod__id'],'uid');
			}

            unset($_SESSION['msvod__id'],$_SESSION['msvod__name'],$_SESSION['msvod__login']);

            //清除记住登录
	        $this->cookie->set_cookie("user_id");
			$this->cookie->set_cookie("user_login");

	        //--------------------------- Ucenter ---------------------------
	        $log=(User_Uc_Mode==1)?uc_user_synlogout:'';
	        //--------------------------- Ucenter ---------------------------

            msg_url(L('logout_01').$log,userurl(site_url('user/login')),'ok');  //退出登录成功
	}
}
