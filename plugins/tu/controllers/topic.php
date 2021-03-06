<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-12-03
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topic extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('tu');
		    $this->load->model('MsdjTpl'); //装载视图模型
	}

    //专题列表
	public function lists($page = 0)
	{
            $page  = intval($page);   //页数
            if($page==0) $page=1;

            //判断运行模式,生成则跳转至静态页面
			$html=config('Html_Uri');
	        if(config('Web_Mode')==3 && $html['topic/lists']['check']==1 && !defined('MOBILE')){
                //获取静态路径
				$Htmllink=LinkUrl('topic','lists',0,$page,'tu');
				header("Location: ".$Htmllink);
				exit;
			}
			$row=array();
			//装载模板并输出
	        $this->MsdjTpl->plub_list($row,1,'lists',$page,'',FALSE,'topic.html','topic','','图片专题');
	}

    //专题内容
	public function show($id=0)
	{
            $id    = intval($id);   //ID
            //判断ID
            if($id==0) msg_url('出错了，ID不能为空！',Web_Path);
            //获取数据
		    $row=$this->MsdjDB->get_row_arr('tu_topic','*',$id);
		    if(!$row || $row['yid']>0){
                     msg_url('出错了，该专题不存在！',Web_Path);
		    }
            //判断运行模式,生成则跳转至静态页面
			$html=config('Html_Uri');
	        if(config('Web_Mode')==3 && $html['topic/show']['check']==1 && !defined('MOBILE')){
                //获取静态路径
				$Htmllink=LinkUrl('topic','show',$id,1,'tu');
				header("Location: ".$Htmllink);
				exit;
			}
			//装载模板并输出
	        $Mark_Text=$this->MsdjTpl->plub_show('topic',$row,$id,true,'topic-show.html',$row['name'],$row['name']);
			//评论
			$Mark_Text=str_replace("[topic:pl]",get_pl('tu',$id,1),$Mark_Text);
			//增加人气
			$Mark_Text=hits_js($Mark_Text,hitslink('hits/ids/'.$id.'/topic','tu'));
            echo $Mark_Text;
			$this->cache->end(); //由于前面不是直接输出，所以这里需要加入写缓存
	}
}


