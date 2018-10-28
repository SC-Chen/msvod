<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-04-27
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cookie类
 */
class Cookie {

	function __construct()
	{
		log_message('debug', "Native Session Class Initialized");
	}

	//设置 cookie
	public static function set_cookie($var, $value = '', $time = 0) {
		$time = $time > 0 ? $time : ($value == '' ? time() - 3600 : 0);
		$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
		$var = MS_Cookie_Prefix.$var;
        $ips=explode(':',$_SERVER['HTTP_HOST']);
		$Domain = (MS_Cookie_Domain=='' && $_SERVER['HTTP_HOST']!='localhost' && !preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/",$ips[0]))?host_ym():MS_Cookie_Domain;
		setcookie($var,sys_auth($value,'E',$var.MS_Encryption_Key),$time, Web_Path, $Domain, $s);
	}

    //获取cookie
    public static function get_cookie($var, $default = '') {
		$var = MS_Cookie_Prefix.$var;
		$value = isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var],'D',$var.MS_Encryption_Key) : $default;
		$value = safe_replace($value);
		return $value;
	}
}
