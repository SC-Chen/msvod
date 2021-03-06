<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-09-20
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Html extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjAdmin');
	        $this->MsdjAdmin->Admin_Login();
			$this->lang->load('admin_html');
			$this->load->model('MsdjTpl');
	}

	public function index()
	{
		    if(Web_Mode!=2){
                 admin_msg(L('plub_01'),site_url('admin/opt/main'),'no');  //动态模式不用生成
			}
			$this->load->get_templates(); //转换视图为前台
            $html=$this->MsdjTpl->home(TRUE);
			$file=FCPATH.Html_Index;
			if(write_file($file, $html)){
                 admin_msg(L('plub_02'),site_url('admin/opt/main'),'ok'); //生成成功
			}else{
                 admin_msg(L('plub_03'),site_url('admin/opt/main'),'no'); //根目录没有写入权限
			}
	}

}
