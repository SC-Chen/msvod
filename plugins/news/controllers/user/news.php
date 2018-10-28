<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-08
 */
class News extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('news');
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
	        $this->MsdjUser->User_Login();
			$this->load->helper('string');
	}

    //已审核
	public function index()
	{
		    $cid=intval($this->uri->segment(4)); //分类ID
		    $page=intval($this->uri->segment(5)); //分页
			//模板
			$tpl='news.html';
			//URL地址
		    $url='news/index/'.$cid;
            $sqlstr = "select {field} from ".MS_SqlPrefix."news where yid=0 and uid=".$_SESSION['msvod__id'];
            if($cid>0){
				$cids=getChild($cid);
                $sqlstr.= " and cid in(".$cids.")";
			}
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='我的小说 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
			$Mark_Text=str_replace("[news:cid]",$cid,$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

    //待审核
	public function verify()
	{
		    $cid=intval($this->uri->segment(4)); //分类ID
		    $page=intval($this->uri->segment(5)); //分页
			//模板
			$tpl='verify.html';
			//URL地址
		    $url='news/verify/'.$cid;
            $sqlstr = "select {field} from ".MS_SqlPrefix."news where yid=1 and uid=".$_SESSION['msvod__id'];
            if($cid>0){
				$cids=getChild($cid);
                $sqlstr.= " and cid in(".$cids.")";
			}
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='待审小说 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
			$Mark_Text=str_replace("[news:cid]",$cid,$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//分享小说
	public function add()
	{
			//模板
			$tpl='add.html';
			//URL地址
		    $url='news/add';
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];

			//检测发表权限
			$rowz=$this->MsdjDB->get_row('userzu','aid,sid',$row['zid']);
			if(!$rowz || $rowz->aid==0){
                 msg_url('您所在会员组没有权限发表小说~!','javascript:history.back();');
			}
			
			//装载模板
			$title='小说投稿 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'','',$ids,true,false);
			//token
			$Mark_Text=str_replace("[user:token]",get_token('news_token'),$Mark_Text);
			//提交地址
			$Mark_Text=str_replace("[user:newssave]",spacelink('news,save','news'),$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//上传小说保存
	public function save()
	{
			$token=$this->input->post('token', TRUE);
			if(!get_token('news_token',1,$token)) msg_url('非法提交~!','javascript:history.back();');
			//检测发表权限
			$zuid=getzd('user','zid',$_SESSION['msvod__id']);
			$rowu=$this->MsdjDB->get_row('userzu','aid,sid',$zuid);
			if(!$rowu || $rowu->aid==0){
                 msg_url('您所在会员组没有权限发表小说~!','javascript:history.back();');
			}
			//检测发表数据是否需要审核
			$news['yid']=($rowu->sid==1)?0:1;
			//选填字段
			$news['cion']=intval($this->input->post('cion'));
			$news['pic']=$this->input->post('pic', TRUE, TRUE);
			$news['tags']=$this->input->post('tags', TRUE, TRUE);
			$news['info']=$this->input->post('info', TRUE, TRUE);
			$news['uid']=$_SESSION['msvod__id'];
			$news['addtime']=time();
            //必填字段
			$news['name']=$this->input->post('name', TRUE, TRUE);
			$news['cid']=intval($this->input->post('cid'));
			$news['content']=remove_xss($this->input->post('content'));
            //检测必须字段
			if($news['cid']==0) msg_url('请选择小说分类~!','javascript:history.back();');
			if(empty($news['name'])) msg_url('小说名称不能为空~!','javascript:history.back();');
			if(empty($news['content'])) msg_url('小说内容不能为空~!','javascript:history.back();');
            //截取概述
			$news['info'] = sub_str(str_checkhtml($news['content']),120);
            //增加到数据库
            $did=$this->MsdjDB->get_insert('news',$news);
			if(intval($did)==0){
				 msg_url('小说发布失败，请稍候再试~!','javascript:history.back();');
			}
            //摧毁token
            get_token('news_token',2);
			//增加动态
		    $dt['dir'] = 'news';
		    $dt['uid'] = $_SESSION['msvod__id'];
		    $dt['did'] = $did;
		    $dt['yid'] = $news['yid'];
		    $dt['title'] = '发布了小说';
		    $dt['name'] = $news['name'];
		    $dt['link'] = linkurl('show','id',$did,1,'news');
		    $dt['addtime'] = time();
            $this->MsdjDB->get_insert('dt',$dt);
			//如果免审核，则给会员增加相应金币、积分
			if($news['yid']==0){
			     $addhits=getzd('user','addhits',$_SESSION['msvod__id']);
				 if($addhits<User_Nums_Add){
                     $this->db->query("update ".MS_SqlPrefix."user set cion=cion+".User_Cion_Add.",jinyan=jinyan+".User_Jinyan_Add.",addhits=addhits+1 where id=".$_SESSION['msvod__id']."");
				 }
				 msg_url('恭喜您，小说发布成功~!',spacelink('news','news'));
			}else{
				 msg_url('恭喜您，小说发布成功,请等待管理员审核~!',spacelink('news/verify','news'));
			}
	}
}

