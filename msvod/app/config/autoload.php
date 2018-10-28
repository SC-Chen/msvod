<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$autoload['packages']  = array();
$autoload['helper']    = array('url','common','link');
$autoload['config']    = array();
if(defined('PLUBPATH')){
	if(defined('IS_ADMIN') && file_exists(FCPATH.'plugins/'.PLUBPATH.'/language/'.MS_Language.'/admin_lang.php')){
        $autoload['language']  = array('common_msvod','admin');
    }elseif(file_exists(FCPATH.'plugins/'.PLUBPATH.'/language/'.MS_Language.'/plub_lang.php')){
        $autoload['language']  = array('common_msvod','plub');
	}
}else{
    $autoload['language']  = array('common_msvod');
}
if(strpos($_SERVER['REQUEST_URI'],'index.php/install/') === FALSE){
    $autoload['libraries'] = array('cookie','session','skins','cache');
    $autoload['model']     = array('MsdjDB');
}else{
    $autoload['libraries'] = array();
    $autoload['model']     = array();
}
