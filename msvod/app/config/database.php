<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$active_group = 'default';
$active_record = TRUE;
$db['default']['hostname'] = MS_Sqlserver;
$db['default']['username'] = MS_Sqluid;
$db['default']['password'] = MS_Sqlpwd;
$db['default']['database'] = MS_Sqlname;
$db['default']['dbdriver'] = MS_Dbdriver;
$db['default']['dbprefix'] = MS_SqlPrefix;
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = (ERROR_MSG=='development')?TRUE:FALSE;
$db['default']['cache_ff'] = (!defined('IS_ADMIN'))?MS_Cache_On:FALSE;
$db['default']['cachedir'] = "cache/".MS_Cache_Dir."/";
$db['default']['char_set'] = MS_Sqlcharset;
$db['default']['dbcollat'] = 'gbk_chinese_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = FALSE;
$db['default']['stricton'] = FALSE;

