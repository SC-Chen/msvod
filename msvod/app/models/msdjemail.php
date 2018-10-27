<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2013 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2013-06-12
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MsdjEmail extends CI_Model
{
    function __construct (){
	       parent:: __construct ();
	       $config['crlf']          = "\r\n";
           $config['newline']       = "\r\n";
           $config['charset']       = 'gbk';
           $config['protocol']      = 'smtp';
           $config['smtp_timeout']  = 5;
           $config['wordwrap']      = TRUE;
           $config['mailtype']      = 'html';
           $config['smtp_host']=MS_Smtphost; 
           $config['smtp_port']=MS_Smtpport;
           $config['smtp_user']=MS_Smtpuser;
           $config['smtp_pass']=MS_Smtppass;
           $this->load->library('email', $config);
    }

    //发送EMAIL
    function send($tomail,$title,$neir) {
		   if(MS_Smtpmode==0) return FALSE;
           $this->email->from(MS_Smtpmail, MS_Smtpname);
           $this->email->to(trim($tomail)); 
           $this->email->subject($title);
           $this->email->message($neir); 
		   if ( ! $this->email->send()){
                //echo $this->email->print_debugger();  //返回信息
                return FALSE;
		   }else{
                return TRUE;
		   }
    }
}

