<?php if (!defined('FCPATH')) exit('No direct script access allowed');
return array (
  'Web_Mode' => 1,
  'Skins_Dir' => 'msvod/msvod_html/',
  'User_Dir' => 'msvod/msvod_html/',
  'Mobile_Dir' => 'msvod/msvod_html/',
  'Mobile_Is' => 1,
  'Cache_Is' => 0,
  'Cache_Time' => 1,
  'Ym_Mode' => 0,
  'Ym_Url' => 'www.msvod.cc',
  'User_Qx' => '',
  'User_Dj_Qx' => '',
  'Rewrite_Uri' => 
  array (
    'lists' => 
    array (
      'title' => '�б�ҳ����',
      'uri' => 'lists/index/{sort}/{id}/{page}',
      'url' => 'list-{sort}-{id}-{page}.html',
    ),
    'play' => 
    array (
      'title' => 'VIP����ҳ����',
      'uri' => 'play/index/id/{id}',
      'url' => 'play-{id}.html',
    ),
    'skvod' => 
    array (
      'title' => '�Կ�����ҳ����',
      'uri' => 'skvod/index/id/{id}',
      'url' => 'skvod-{id}.html',
    ),
    'down' => 
    array (
      'title' => '����ҳ����',
      'uri' => 'down/index/id/{id}',
      'url' => 'down-{id}.html',
    ),
  ),
  'Html_Uri' => 
  array (
    'lists' => 
    array (
      'title' => '�б�ҳ����',
      'url' => 'look/list-{sort}-{id}-{page}.html',
      'check' => '1',
    ),
    'play' => 
    array (
      'title' => '����ҳ����',
      'url' => 'look/play/{id}.html',
      'check' => '1',
    ),
    'down' => 
    array (
      'title' => '����ҳ����',
      'url' => 'look/down/{id}.html',
      'check' => '1',
    ),
  ),
  'Seo' => 
  array (
    'title' => '��Ƶ',
    'keywords' => '��Ƶ',
    'description' => '��Ƶ',
  ),
);?>