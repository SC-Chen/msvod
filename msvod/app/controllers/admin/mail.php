<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2016-9-01
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mail extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjAdmin');
			$this->lang->load('admin_mail');
	        $this->MsdjAdmin->Admin_Login();
	}

	public function index()
	{
            $this->load->view('mail_setting.html');
	}

	public function add()
	{
            $this->load->view('mail_add.html');
	}

	public function save()
	{
		    $MS_Smtpmode = intval($this->input->post('MS_Smtpmode', TRUE));
		    $MS_Smtphost = $this->input->post('MS_Smtphost', TRUE);
		    $MS_Smtpport = intval($this->input->post('MS_Smtpport', TRUE));
		    $MS_Smtpuser = $this->input->post('MS_Smtpuser', TRUE);
		    $MS_Smtppass = $this->input->post('MS_Smtppass', TRUE);
		    $MS_Smtpmail = $this->input->post('MS_Smtpmail', TRUE);
		    $MS_Smtpname = $this->input->post('MS_Smtpname', TRUE);

            if($MS_Smtpmode==0)   $MS_Smtpmode=2;
            if($MS_Smtpport==0)   $MS_Smtpport=25;
			if($MS_Smtppass==substr(MS_Smtppass,0,3).'******'){
                  $MS_Smtppass=MS_Smtppass;
			}

            //判断主要数据不能为空
		    if ($MS_Smtpmode==1 && (empty($MS_Smtphost)||empty($MS_Smtpuser)||empty($MS_Smtppass)||empty($MS_Smtpmail))){
			      admin_msg(L('plub_01'),'javascript:history.back();','no');
		    }

	        $strs="<?php"."\r\n";
	        $strs.="define('MS_Smtpmode',".$MS_Smtpmode.");      //SMTP开关     \r\n";
	        $strs.="define('MS_Smtphost','".$MS_Smtphost."');      //SMTP服务器      \r\n";
	        $strs.="define('MS_Smtpport','".$MS_Smtpport."');      //SMTP端口    \r\n";
	        $strs.="define('MS_Smtpuser','".$MS_Smtpuser."');      //SMTP帐号     \r\n";
	        $strs.="define('MS_Smtppass','".$MS_Smtppass."');      //SMTP密码     \r\n";
	        $strs.="define('MS_Smtpmail','".$MS_Smtpmail."');      //发送EMAIL     \r\n";
	        $strs.="define('MS_Smtpname','".$MS_Smtpname."');      //发送者名称";

            //写文件
            if (!write_file(MSVOD.'lib/Ms_Mail.php', $strs)){
                      admin_msg(L('plub_02'),site_url('admin/mail'),'no');
            }else{
                      admin_msg(L('plub_03'),site_url('admin/mail'));
            }
	}

	public function add_save()
	{
		    $sid = intval($this->input->post('sid', TRUE));
		    $email = $this->input->post('email', TRUE);
		    $email2 =  nl2br($this->input->post('email2'));
		    $zu = $this->input->post('zu', TRUE);
		    $title = $this->input->post('title', TRUE);
		    $neir = $this->input->post('neir');

		    if (empty($title)||empty($neir)){
			      admin_msg(L('plub_04'),'javascript:history.back();','no');
		    }

			if($sid==1){
                 $arr[]=$email;
			}elseif($sid==2){
				 $arr=explode("<br />",$email2);
			}else{
				 $arr=array();
				 if(intval($zu)>0){
		               $result=$this->db->query("select email from ".MS_SqlPrefix."user where zid=".$zu."");
				 }elseif($zu==0){
		               $result=$this->db->query("select email from ".MS_SqlPrefix."user where zid=0");
				 }else{
		               $result=$this->db->query("select email from ".MS_SqlPrefix."user");
				 }
		         foreach ($result->result() as $row) {
					    if(!empty($row->email)){
          		              $arr[]=$row->email;
						}
		         }
			}
		    if(empty($arr)){
			      admin_msg(L('plub_05'),'javascript:history.back();','no');
		    }
            $this->load->model('MsdjEmail');
			foreach ($arr as $email){
				   ob_end_flush();//关闭缓存 
			       $res=$this->MsdjEmail->send($email,$title,$neir);
				   if($res){
                       echo $email."----->OK<br/>";
				   }else{
                       echo "<font color=red>".$email."----->NO</font><br/>";
				   }
				   ob_flush();flush();
            }
            admin_msg(L('plub_06'),'javascript:history.back();','ok');
	}
}

