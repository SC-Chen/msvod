<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-08
 */
class Look extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('tu');
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
	        $this->MsdjUser->User_Login();
	}

    //欣赏记录
	public function index()
	{
		    $cid=intval($this->uri->segment(4)); //分类ID
		    $page=intval($this->uri->segment(5)); //分页
			//模板
			$tpl='look.html';
			//URL地址
		    $url='look/index/'.$cid;
            $sqlstr = "select {field} from ".MS_SqlPrefix."tu_look where uid=".$_SESSION['msvod__id'];
            if($cid>0){
				$cids=getChild($cid);
                $sqlstr.= " and cid in(".$cids.")";
			}
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='我欣赏的图片 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,'',$sqlstr,$ids,true,false);
			$Mark_Text=str_replace("[tu:cid]",$cid,$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}
}

