<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
return array(
//��̨�˵�����	
'admin' => array(
array(
'name' => 'ͼƬ����',
'menu' => array(
array(
'name' => 'ͼƬ����',
'link' => 'admin/tu'
),
array(
'name' => 'ͼƬ����',
'link' => 'admin/lists'
),
//array(
//'name' => 'ͼƬר��',
//'link' => 'admin/topic'
//),
array(
'name' => '������¼',
'link' => 'admin/look'
),
),
),
array(
'name' => '��̬����',
'menu' => array(
//array(
//'name' => '���ɰ����ҳ',
//'link' => 'admin/html/index'
//),
array(
'name' => '���ɷ���ҳ',
'link' => 'admin/html/type'
),
array(
'name' => '��������ҳ',
'link' => 'admin/html/show'
),
//array(
//'name' => '����ר��ҳ',
//'link' => 'admin/html/topic'
//),
array(
'name' => '�����Զ���ҳ',
'link' => 'admin/html/opt'
),
),
)
),
//��Ա���Ĳ˵�����
'user' => array(
array(
'name' => 'ͼƬ����',
'menu' => array(
array(
'name' => '�ҵ�ͼƬ',
'link' => 'user/tu',
),
array(
'name' => '����ͼƬ',
'link' => 'user/tu/add',
)
)
),
),
);
