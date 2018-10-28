<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-16-16
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('news');
		    $this->load->model('MsdjTpl'); //装载视图模型
	}

    //搜索列表
	public function index()
	{
		    $data['tags'] = $this->input->get_post('tags',true,true);
		    $data['name'] = $this->input->get_post('name',true,true);
		    $data['key'] = $this->input->get_post('key',true,true);
		    $data['cid'] = intval($this->input->get_post('cid',true));
            $page  = intval($this->input->get_post('page',true));   //页数
            if($page==0) $page=1;
			//装载模板并输出
	        $this->MsdjTpl->plub_search('news',$data,$page);
	}
}


