<?php
/**
 * @msvod 3.5 open source management system
 * @copyright 2009-2013 msvod.cc. All rights reserved.
 * @Author:Msvod By
 * @Dtime:2013-04-27
 */

//������IP һ��Ϊlocalhost����127.0.0.1
define('MS_Sqlserver', '127.0.0.1');

//���ݿ�����
define('MS_Sqlname', 'msvod');

//���ݿ��ǰ׺
define('MS_SqlPrefix', 'ms_');

//���ݿ��û���
define('MS_Sqluid', 'root');

//���ݿ�����
define('MS_Sqlpwd', '');

//���ݿⷽʽ
define('MS_Dbdriver', 'mysqli');

//Mysql���ݿ����
define('MS_Sqlcharset', 'gbk');

//���ݿ⻺�翪��
define('MS_Cache_On', FALSE);

//���ݿ⻺��Ŀ¼
define('MS_Cache_Dir', 'sql');

//���ݿ⻺��ʱ��
define('MS_Cache_Time', 7200);

//encryption_key��Կ
define('MS_Encryption_Key', 'msvod_P8NJGgsYLj');

//��̨����ܿ���,1Ϊ����0Ϊ�ر�
define('MS_Safe_Card', 1);

//session�洢��ʽ��1Ϊ�ļ��洢��2ΪMysql���ݿ�
define('MS_Session_Is', 2);

//session�洢ʱ��
define('MS_Session_Time', 3600);

//Cookie ǰ׺��ͬһ�����°�װ����ϵͳʱ�����޸�Cookieǰ׺
define('MS_Cookie_Prefix', 'msvod_');

//Cookie_Domain ������,ʹ�ö����������ʱ�������ã���ʽ�� .msvod.cc
define('MS_Cookie_Domain', '');

//Cookie �������ڣ�0 ��ʾ�����������
define('MS_Cookie_Ttl', 0);
