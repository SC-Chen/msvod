<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-12-16
 */
class Lists extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->helper('news');
		    $this->load->model('MsdjAdmin');
	        $this->MsdjAdmin->Admin_Login();
	}

    //小说分类
	public function index()
	{
            $sql_string = "SELECT * FROM ".MS_SqlPrefix."news_list where fid=0 order by xid asc";
	        $query = $this->db->query($sql_string); 
	        $data['news_list'] = $query->result();
            $this->load->view('news_list.html',$data);
	}

    //显示、隐藏操作
	public function init()
	{
            $ac  = $this->input->get_post('ac',true);
            $id   = intval($this->input->get_post('id'));
            $sid  = intval($this->input->get_post('sid'));
            if($ac=='zt'){ //显示
                  $edit['yid']=$sid;
				  $str=($sid==0)?'<a title="点击隐藏" href="javascript:get_cmd(\''.site_url('news/admin/lists/init').'?sid=1\',\'zt\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/ok.gif" /></a>':'<a title="点击显示" href="javascript:get_cmd(\''.site_url('news/admin/lists/init').'?sid=0\',\'zt\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/no.gif" /></a>';
			}
            $this->MsdjDB->get_update('news_list',$id,$edit);
            die($str);
	}

    //批量修改分类
	public function plsave()
	{
            $ids=$this->input->post('id', TRUE); 
            if(empty($ids)){
                    admin_msg('请选择要操作的数据~!','javascript:history.back();','no');
			}
			foreach ($ids as $id) {
		            $data['name']=$this->input->post('name_'.$id, TRUE);
		            $data['bname']=$this->input->post('bname_'.$id, TRUE);
		            $data['skins']=$this->input->post('skins_'.$id, TRUE);
		            $data['xid']=intval($this->input->post('xid_'.$id, TRUE)); 
                    $this->MsdjDB->get_update('news_list',$id,$data);
			}
            admin_msg('恭喜您，操作成功~!',site_url('news/admin/lists'),'ok');  //操作成功
	}

    //批量转移分类
	public function zhuan()
	{
            $ids = $this->input->get_post('id', TRUE);
            $cid = intval($this->input->get_post('cid')); 
            if(empty($ids)){
                    admin_msg('请选择要操作的数据~!','javascript:history.back();','no');
			}
            if($cid==0){
                    admin_msg('请选择目标分类~!','javascript:history.back();','no');
			}
			$ids=implode(',', $ids);
            $this->db->query("update ".MS_SqlPrefix."news set cid=".$cid." where cid in (".$ids.")");
            admin_msg('恭喜您，操作成功~!',site_url('news/admin/lists'),'ok');  //操作成功
	}

    //分类新增、修改
	public function edit()
	{
            $id   = intval($this->input->get('id'));
            $fid  = intval($this->input->get('fid'));
			if($id==0){
                $data['id']=0;
                $data['fid']=$fid;
                $data['yid']=0;
                $data['xid']=0;
                $data['name']='';
                $data['bname']='';
                $data['skins']='list.html';
                $data['title']='';
                $data['keywords']='';
                $data['description']='';
			}else{
                $row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."news_list where id=".$id."")->row(); 
			    if(!$row) admin_msg('该条记录不存在~!','javascript:history.back();','no');  //记录不存在

                $data['id']=$row->id;
                $data['fid']=$row->fid;
                $data['yid']=$row->yid;
                $data['xid']=$row->xid;
                $data['name']=$row->name;
                $data['bname']=$row->bname;
                $data['skins']=$row->skins;
                $data['title']=$row->title;
                $data['keywords']=$row->keywords;
                $data['description']=$row->description;
			}
            $this->load->view('list_edit.html',$data);
	}

    //分类保存
	public function save()
	{
            $id   = intval($this->input->post('id'));
            $data['yid']=intval($this->input->post('yid'));
            $data['fid']=intval($this->input->post('fid'));
            $data['xid']=intval($this->input->post('xid'));
            $data['name']=$this->input->post('name',true);
            $data['bname']=$this->input->post('bname',true);
            $data['skins']=$this->input->post('skins',true);
            $data['title']=$this->input->post('title',true);
            $data['keywords']=$this->input->post('keywords',true);
            $data['description']=$this->input->post('description',true);

			if($id==0){ //新增
                 $this->MsdjDB->get_insert('news_list',$data);
			}else{
                 $this->MsdjDB->get_update('news_list',$id,$data);
			}
            admin_msg('恭喜您，操作成功~!',site_url('news/admin/lists'),'ok');  //操作成功
	}

    //分类删除
	public function del()
	{
            $ids = $this->input->get_post('id');
			if(empty($ids)) admin_msg('请选择要删除的数据~!','javascript:history.back();','no');
			if(is_array($ids)){
			     $idss=implode(',', $ids);
			}else{
			     $idss=$ids;
			}
			$this->MsdjDB->get_del('news_list',$ids,'fid');
			$this->MsdjDB->get_del('news_list',$ids);
            admin_msg('恭喜您，删除成功~!','javascript:history.back();','ok');  //操作成功
	}
}

