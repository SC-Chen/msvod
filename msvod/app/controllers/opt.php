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
		    $this->load->model('MsdjTpl');
	}

	public function index()
	{
            $name = $this->uri->segment(2);   //页面标示
            if(empty($name)){
                    msg_url(L('opt_01'),Web_Path);
            }
            $this->MsdjTpl->opt($name);
	}
}
