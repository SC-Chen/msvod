<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By
 * @Dtime:2014-09-20
 */
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Sitemap extends msvod_Controller {

	function __construct() {
		parent::__construct();
	}

	//网站地图
	public function index() {
		header("Content-type:text/xml;charset=utf-8");
		$this->load->get_templates('common');
		$Mark_Text = $this->load->view('sitemap.html', '', true);
		$Mark_Text = $this->skins->template_parse($Mark_Text, false);
		echo '<?xml version="1.0" encoding="GBK" ?>' . $Mark_Text;
	}
}
