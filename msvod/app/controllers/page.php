<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-11-24
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
	}

	public function index()
	{
            $name = $this->uri->segment(3);   //页面标示
            if(empty($name)){
                    msg_url(L('page_01'),Web_Path);
            }
            //获取数据
		    $row=$this->MsdjDB->get_row_arr('page','*',$name,'name');
		    if(!$row){
                    msg_url(L('page_02'),Web_Path);
		    }
            $this->MsdjTpl->page($row);
	}
}
