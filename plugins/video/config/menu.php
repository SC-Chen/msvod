<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

return array(

//��̨�˵�����	
'admin' => array(
array(
'name' => '��Ƶ����',
'menu' => array(
array(
'name' => '��Ƶ����',
'link' => 'admin/video'
),
array(
'name' => '��Ƶ����',
'link' => 'admin/lists'
),
array(
'name' => '��������',
'link' => 'admin/server'
),
//array(
//'name' => '��Ƶר��',
//'link' => 'admin/topic'
//),
//array(
//'name' => '��Ƶɨ��',
//'link' => 'admin/saomiao'
//),
array(
'name' => '���ż�¼',
'link' => 'admin/opt/play'
),
array(
'name' => '���ؼ�¼',
'link' => 'admin/opt/down'
),
array(
'name' => '�ղؼ�¼',
'link' => 'admin/opt/fav'
),
array(
'name' => '����������',
'link' => '../admin/playsz'
),
array(
'name' => '����������',
'link' => 'admin/tools'
),
),
),
//array(
//'name' => '��̬����',
//'menu' => array(
//array(
//'name' => '���ɰ����ҳ',
//'link' => 'admin/html/index'
//),
//array(
//'name' => '���ɷ���ҳ',
//'link' => 'admin/html/type'
//),
//array(
//'name' => '���ɲ���ҳ',
//'link' => 'admin/html/play'
//),
//array(
//'name' => '��������ҳ',
//'link' => 'admin/html/down'
//),
//array(
//'name' => '����ר��',
//'link' => 'admin/html/topic'
//),
//array(
//'name' => '�����Զ���ҳ',
//'link' => 'admin/html/opt'
//),
//),
//)
),

//��Ա���Ĳ˵�����
'user' => array(
array(
'name' => '��Ƶ����',
'menu' => array(
array(
'name' => '�ҵ���Ƶ',
'link' => 'user/video',
),
array(
'name' => '�ϴ���Ƶ',
'link' => 'user/video/add',
),
//array(
//'name' => '�ҵ�ר��',
//'link' => 'user/album',
//)
)
),
),
);
