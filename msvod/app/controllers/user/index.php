<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-04-27
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends msvod_Controller {
	function __construct(){
		    parent::__construct();
	}
	public function index()
	{
		    $template=$this->load->view('index.html','',true);
			$Mark_Text=str_replace("{msvod:title}","会员 - ".Web_Name,$template);
			$Mark_Text=str_replace("{msvod:keywords}",Web_Keywords,$Mark_Text);
			$Mark_Text=str_replace("{msvod:description}",Web_Description,$Mark_Text);
            $Mark_Text=$this->skins->template_parse($Mark_Text,true);
			echo $Mark_Text;
	}
}
