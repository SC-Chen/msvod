<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2016-9-01
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tags extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjAdmin');
	        $this->MsdjAdmin->Admin_Login();
			$this->lang->load('admin_tags');
	}

    //TAG标签列表
	public function index()
	{
            $sql_string = "SELECT * FROM ".MS_SqlPrefix."tags where fid=0 order by xid asc";
	        $query = $this->db->query($sql_string); 
	        $data['tags'] = $query->result();
            $this->load->view('tags.html',$data);
	}

    //新增标签
	public function add_save()
	{
            $data['fid']=intval($this->input->get('fid', TRUE));
            $data['xid']=intval($this->input->get('xid', TRUE));
		    $data['name']=$this->input->get('name', TRUE);

            if(empty($data['name'])){
                    admin_msg(L('plub_01'),'javascript:history.back();','no');
			}

			$this->MsdjDB->get_insert('tags',$data);
            admin_msg(L('plub_02'),site_url('admin/tags'),'ok');  //操作成功
	}

    //批量修改
	public function save()
	{
            $ids=$this->input->post('id', TRUE); 
            if(empty($ids)){
                    admin_msg(L('plub_03'),'javascript:history.back();','no');
			}
			foreach ($ids as $id) {
		            $data['name']=$this->input->post('name_'.$id, TRUE);
		            $data['xid']=intval($this->input->post('xid_'.$id, TRUE)); 
                    $this->MsdjDB->get_update('tags',$id,$data);
			}
            admin_msg(L('plub_02'),site_url('admin/tags'),'ok');  //操作成功
	}

    //删除标签
	public function del()
	{
            $fid=intval($this->input->get('fid', TRUE));
            $id=intval($this->input->get('id', TRUE));

            if($fid>0){
			    $this->db->query("delete from ".MS_SqlPrefix."tags where fid=".$id."");
			}
			$this->MsdjDB->get_del('tags',$id);

            admin_msg(L('plub_02'),site_url('admin/tags'),'ok');  //操作成功
	}
}

