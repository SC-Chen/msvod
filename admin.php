<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By
 * @Dtime:2016-9-01
 */
define('IS_ADMIN', TRUE); // ��̨��ʶ
define('ADMINSELF', pathinfo(__FILE__, PATHINFO_BASENAME)); // ��̨�ļ���
define('SELF', ADMINSELF);
define('FCPATH', str_replace("\\", "/", dirname(__FILE__) . '/')); // ��վ��Ŀ¼
require 'index.php'; // �������ļ�
