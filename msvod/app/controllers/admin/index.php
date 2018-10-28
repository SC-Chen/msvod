<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By
 * @Dtime:2016-9-01
 */
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Index extends msvod_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('MsdjAdmin');
		$this->MsdjAdmin->Admin_Login();
	}
	public function index() {
		$this->load->view('index.html');
	}
}
