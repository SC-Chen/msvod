<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-11-24
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opt extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('news');
		    $this->load->model('MsdjTpl');
	}

	public function index($name)
	{
            if(empty($name)){
                    msg_url('出错了，模板标示为空！',Web_Path);
            }
            $this->MsdjTpl->opt($name);
	}
}
