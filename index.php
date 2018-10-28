<?php

define('Web_Url', $_SERVER['HTTP_HOST']);
date_default_timezone_set("Asia/Shanghai");
define('REQUEST_URI', $_SERVER['REQUEST_URI']);
define('ERROR_MSG', 'development');
if (defined('ERROR_MSG')) {
	switch (ERROR_MSG) {
	case 'development':
		error_reporting(E_ALL);
		break;
	case 'production':
		error_reporting(0);
		break;
	}
}
if (!defined('SELF')) {
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
}
if (!defined('FCPATH')) {
	define('FCPATH', str_replace("\\", "/", str_replace(SELF, '', __FILE__)));
}
if (defined('STDIN')) {
	chdir(dirname(__FILE__));
}
define('MSVOD', FCPATH . 'msvod/');
define('ENVIRONMENT', MSVOD . 'config/');
$app_folder = 'msvod/app';
$view_folder = 'msvod/tpl';
$system_folder = 'vendor/codeigniter/framework/system';
require_once MSVOD . 'lib/Ms_Msvod.php';
define('EXT', '.php');
define('BASEPATH', FCPATH .$system_folder.DIRECTORY_SEPARATOR);
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));
define('APPPATH', FCPATH . $app_folder . DIRECTORY_SEPARATOR);
define('VIEWPATH', FCPATH . $view_folder . DIRECTORY_SEPARATOR);
define('MSVODPATH', FCPATH . 'packs/');
require_once BASEPATH . 'core/CodeIgniter.php';
