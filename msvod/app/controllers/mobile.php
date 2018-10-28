<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-11-24
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
	}

	public function index()
	{
            $this->MsdjTpl->mobile();
	}
}
