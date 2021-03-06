<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-12-09
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hits extends msvod_Controller {

	function __construct(){
		  parent::__construct();
		  $this->lang->load('home');
          $this->load->library('user_agent');
          if(!$this->agent->is_referral()) show_error(L('ajax_01'),404,Web_Name);
	      //关闭数据库缓存
          $this->db->cache_off();
	}

    //增加人气
	public function ids()
	{
           $id = intval($this->uri->segment(4));   //ID			
		   $row=$this->MsdjDB->get_row('user','name,rhits,zhits,yhits,hits',$id);
		   if(!$row){
			   exit();
		   }
           //增加人气
	       $updata['rhits']=$row->rhits+1;
	       $updata['zhits']=$row->zhits+1;
	       $updata['yhits']=$row->yhits+1;
	       $updata['hits']=$row->hits+1;
           $this->MsdjDB->get_update('user',$id,$updata);
		   //增加访客记录
		   $this->load->model('MsdjUser');
		   //判断是否登录
		   if($this->MsdjUser->User_Login(1) && $id!=$_SESSION['msvod__id']){
                   $rows=$this->db->query("Select id,addtime from ".MS_SqlPrefix."funco where uida=".$id." and uidb=".$_SESSION['msvod__id']."")->row();
			       if(!$rows){
                       $add['uida']=$id;
                       $add['uidb']=$_SESSION['msvod__id'];
                       $add['addtime']=time();
                       $this->MsdjDB->get_insert('funco',$add);
			       }else{  //修改时间
	                   $updata2['addtime']=time();
                       $this->MsdjDB->get_update('funco',$rows->id,$updata2);
				   }
		   }

		   //清空月人气
           $month=@file_get_contents(FCPATH."cache/msvod_time/home-month.txt");
		   if($month!=date('m')){
			    $this->db->query("update ".MS_SqlPrefix."user set yhits=0");
                write_file(FCPATH."cache/msvod_time/home-month.txt",date('m'));
		   }
		   //清空周人气
		   $week=@file_get_contents(FCPATH."cache/msvod_time/home-week.txt");
		   if($week!=date('W',time())){
			    $this->db->query("update ".MS_SqlPrefix."user set zhits=0");
                write_file(FCPATH."cache/msvod_time/home-week.txt",date('W',time()));
		   }
		   //清空日人气
		   $day=@file_get_contents(FCPATH."cache/msvod_time/home-day.txt");
		   if($day!=date('d')){
			    $this->db->query("update ".MS_SqlPrefix."user set rhits=0");
                write_file(FCPATH."cache/msvod_time/home-day.txt",date('d'));
		   }
	}

    //动态加载人气
	public function dt()
	{
           $op = $this->uri->segment(3);   //类型
           $id = intval($this->uri->segment(4));   //ID
		   $dos = array('hits', 'yhits', 'zhits', 'rhits', 'zanhits');
           $op= (!empty($op) && in_array($op, $dos))?$op:'hits';
		   $row=$this->MsdjDB->get_row('user',$op,$id);
		   if(!$row){
			        echo "document.write('0');";
		   }else{
					echo "document.write('".$row->$op."');";
		   }
	}
}
