<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
return array(
//��̨�˵�����	
'admin' => array(
array(
'name' => 'С˵����',
'menu' => array(
array(
'name' => 'С˵����',
'link' => 'admin/news'
),
array(
'name' => 'С˵����',
'link' => 'admin/lists'
),
//array(
//'name' => 'С˵ר��',
//'link' => 'admin/topic'
//),
array(
'name' => '�Ķ���¼',
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
'name' => 'С˵����',
'menu' => array(
array(
'name' => '�ҵ�С˵',
'link' => 'user/news',
),
array(
'name' => '����С˵',
'link' => 'user/news/add',
)
)
),
),
);
