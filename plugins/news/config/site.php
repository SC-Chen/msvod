<?php if (!defined('FCPATH')) exit('No direct script access allowed');
return array (
  'Web_Mode' => 1,
  'Skins_Dir' => 'msvod/msvod_html/',
  'User_Dir' => 'msvod/msvod_html/',
  'Mobile_Dir' => 'msvod/msvod_html/',
  'Mobile_Is' => 1,
  'Cache_Is' => 0,
  'Cache_Time' => 1800,
  'Ym_Mode' => 0,
  'Ym_Url' => 'news.msvod.com',
  'User_Qx' => '',
  'User_Dj_Qx' => '',
  'Rewrite_Uri' => 
  array (
    'lists' => 
    array (
      'title' => '列表页规则',
      'uri' => 'lists/index/{sort}/{id}/{page}',
      'url' => 'list-{sort}-{id}-{page}.html',
    ),
    'show' => 
    array (
      'title' => '内容页规则',
      'uri' => 'show/index/id/{id}',
      'url' => 'show-{id}.html',
    ),
  ),
  'Html_Uri' => 
  array (
    'lists' => 
    array (
      'title' => '列表页规则',
      'url' => 'news/list-{sort}-{id}-{page}.html',
      'check' => '1',
    ),
    'show' => 
    array (
      'title' => '内容页规则',
      'url' => 'news/show-{id}.html',
      'check' => '1',
    ),
  ),
  'Seo' => 
  array (
    'title' => '小说',
    'keywords' => '小说',
    'description' => '小说',
  ),
);?>
