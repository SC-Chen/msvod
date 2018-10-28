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
          $this->load->library('user_agent');
          if(!$this->agent->is_referral()) show_error('您访问的页面不存在~!',404,Web_Name.'提醒您');
	      //关闭数据库缓存
          $this->db->cache_off();
	}

    //增加播放人气
	public function ids()
	{
           $id = intval($this->uri->segment(3));   //ID			
           $op = $this->uri->segment(4);   //方式
		   $zd=($op=='topic')?'tu_topic':'tu';
		   $row=$this->MsdjDB->get_row($zd,'rhits,zhits,yhits,hits',$id);
		   if(!$row){
			   exit();
		   }
           //增加人气
	       $updata['rhits']=$row->rhits+1;
	       $updata['zhits']=$row->zhits+1;
	       $updata['yhits']=$row->yhits+1;
	       $updata['hits']=$row->hits+1;
           $this->MsdjDB->get_update($zd,$id,$updata);
		  //清空月人气
          $month=@file_get_contents(APPPATH."config/month.txt");
		  if($month!=date('m')){
			    $this->db->query("update ".MS_SqlPrefix."tu set yhits=0");
			    $this->db->query("update ".MS_SqlPrefix."tu_topic set yhits=0");
                write_file(APPPATH."config/month.txt",date('m'));
		  }
		  //清空周人气
		  $week=@file_get_contents(APPPATH."config/week.txt");
		  if($week!=date('W',time())){
			    $this->db->query("update ".MS_SqlPrefix."tu set zhits=0");
			    $this->db->query("update ".MS_SqlPrefix."tu_topic set zhits=0");
                write_file(APPPATH."config/week.txt",date('W',time()));
		  }
		  //清空日人气
		  $day=@file_get_contents(APPPATH."config/day.txt");
		  if($day!=date('d')){
			    $this->db->query("update ".MS_SqlPrefix."tu set rhits=0");
			    $this->db->query("update ".MS_SqlPrefix."tu_topic set rhits=0");
                write_file(APPPATH."config/day.txt",date('d'));
		  }
	}

    //动态加载人气
	public function dt()
	{
           $op = $this->uri->segment(3);   //类型
           $id = intval($this->uri->segment(4));   //ID
           $type = $this->uri->segment(5);   //ID
		   $zd=($type=='topic')?'tu_topic':'tu';

		   $dos = array('hits', 'yhits', 'zhits', 'rhits', 'dhits', 'chits');
           $op= (!empty($op) && in_array($op, $dos))?$op:'hits';
		   $row=$this->MsdjDB->get_row($zd,$op,$id);
		   if(!$row){
			        echo "document.write('0');";
		   }else{
					echo "document.write('".$row->$op."');";
		   }
	}
}
