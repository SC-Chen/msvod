<?php
include_once "../msvod/lib/Ms_DB.php";
//����MYSQL���ݿ�������Ϣ
$mysqli_server_name = MS_Sqlserver; //���ݿ����������
$mysqli_username = MS_Sqluid; // �������ݿ��û���
$mysqli_password = MS_Sqlpwd; // �������ݿ�����
$mysqli_database = MS_Sqlname; // ���ݿ������
$mysqli_conn = mysqli_connect($mysqli_server_name, $mysqli_username, $mysqli_password);
?>