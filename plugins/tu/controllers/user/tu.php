<?php if ( ! defined('MSVOD')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-04-08
 */
class Tu extends msvod_Controller {

	function __construct(){
		    parent::__construct();
			$this->load->helper('tu');
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
			$tpl='tu.html';
			//URL地址
		    $url='tu/index/'.$cid;
            $sqlstr = "select {field} from ".MS_SqlPrefix."tu where yid=0 and uid=".$_SESSION['msvod__id'];
            if($cid>0){
				$cids=getChild($cid);
                $sqlstr.= " and cid in(".$cids.")";
			}
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='我的图片 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
			$Mark_Text=str_replace("[tu:cid]",$cid,$Mark_Text);
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
		    $url='tu/verify/'.$cid;
            $sqlstr = "select {field} from ".MS_SqlPrefix."tu where yid=1 and uid=".$_SESSION['msvod__id'];
            if($cid>0){
				$cids=getChild($cid);
                $sqlstr.= " and cid in(".$cids.")";
			}
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//装载模板
			$title='待审图片 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,$page,$tpl,$title,$cid,$sqlstr,$ids,true,false);
			$Mark_Text=str_replace("[tu:cid]",$cid,$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//分享图片
	public function add()
	{
			//模板
			$tpl='add.html';
			//URL地址
		    $url='tu/add';
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];

			//检测发表权限
			$rowz=$this->MsdjDB->get_row('userzu','aid,sid',$row['zid']);
			if(!$rowz || $rowz->aid==0){
                 msg_url('您所在会员组没有权限发表图片~!','javascript:history.back();');
			}
			
			//装载模板
			$title='图片投稿 - 会员中心';
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
            $Mark_Text=$this->MsdjTpl->user_list($row,$url,1,$tpl,$title,'','',$ids,true,false);
			//token
			$Mark_Text=str_replace("[user:token]",get_token('tu_token'),$Mark_Text);
			//提交地址
			$Mark_Text=str_replace("[user:tusave]",spacelink('tu,save','tu'),$Mark_Text);
			//会员版块导航
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->labelif($Mark_Text);
			echo $Mark_Text;
	}

	//上传图片保存
	public function save()
	{
			$token=$this->input->post('token', TRUE);
			if(!get_token('tu_token',1,$token)) msg_url('非法提交~!','javascript:history.back();');
			//检测发表权限
			$zuid=getzd('user','zid',$_SESSION['msvod__id']);
			$rowu=$this->MsdjDB->get_row('userzu','aid,sid',$zuid);
			if(!$rowu || $rowu->aid==0){
                 msg_url('您所在会员组没有权限发表图片~!','javascript:history.back();');
			}
			//检测发表数据是否需要审核
			$tu['yid']=($rowu->sid==1)?0:1;
			//选填字段
			$tu['cion']=intval($this->input->post('cion'));
			$tu['pic']=$this->input->post('pic', TRUE, TRUE);
			$tu['tags']=$this->input->post('tags', TRUE, TRUE);
			$tu['info']=$this->input->post('info', TRUE, TRUE);
			$tu['uid']=$_SESSION['msvod__id'];
			$tu['addtime']=time();
            //必填字段
			$tu['name']=$this->input->post('name', TRUE, TRUE);
			$tu['cid']=intval($this->input->post('cid'));
			$tu['content']=remove_xss($this->input->post('content'));
            //检测必须字段
			if($tu['cid']==0) msg_url('请选择图片分类~!','javascript:history.back();');
			if(empty($tu['name'])) msg_url('图片名称不能为空~!','javascript:history.back();');
			if(empty($tu['content'])) msg_url('图片内容不能为空~!','javascript:history.back();');
            //截取概述
			$tu['info'] = sub_str(str_checkhtml($tu['content']),120);
            //增加到数据库
            $did=$this->MsdjDB->get_insert('tu',$tu);
			if(intval($did)==0){
				 msg_url('图片发布失败，请稍候再试~!','javascript:history.back();');
			}
            //摧毁token
            get_token('tu_token',2);
			//增加动态
		    $dt['dir'] = 'tu';
		    $dt['uid'] = $_SESSION['msvod__id'];
		    $dt['did'] = $did;
		    $dt['yid'] = $tu['yid'];
		    $dt['title'] = '发布了图片';
		    $dt['name'] = $tu['name'];
		    $dt['link'] = linkurl('show','id',$did,1,'tu');
		    $dt['addtime'] = time();
            $this->MsdjDB->get_insert('dt',$dt);
			//如果免审核，则给会员增加相应金币、积分
			if($tu['yid']==0){
			     $addhits=getzd('user','addhits',$_SESSION['msvod__id']);
				 if($addhits<User_Nums_Add){
                     $this->db->query("update ".MS_SqlPrefix."user set cion=cion+".User_Cion_Add.",jinyan=jinyan+".User_Jinyan_Add.",addhits=addhits+1 where id=".$_SESSION['msvod__id']."");
				 }
				 msg_url('恭喜您，图片发布成功~!',spacelink('tu','tu'));
			}else{
				 msg_url('恭喜您，图片发布成功,请等待管理员审核~!',spacelink('tu/verify','tu'));
			}
	}
}

