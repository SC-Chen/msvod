<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2008-2015 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-11-20
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pl extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjAdmin');
			$this->lang->load('admin_pl');
	        $this->MsdjAdmin->Admin_Login();
	}

    //评论列表
	public function index()
	{
            $dir  = $this->input->get_post('dir',true);
            $zd   = $this->input->get_post('zd',true);
            $key  = $this->input->get_post('key',true);
 	        $page = intval($this->input->get('page'));
            if($page==0) $page=1;

	        $data['page'] = $page;
	        $data['dir'] = $dir;
	        $data['zd'] = $zd;
	        $data['key'] = $key;

            $sql_string = "SELECT * FROM ".MS_SqlPrefix."pl where 1=1";
			if(!empty($dir)){
	             $sql_string.= " and dir='".$dir."'";
			}
			if(!empty($key)){
				 if($zd=='did'){
				     $sql_string.= " and did=".intval($key)."";
				 }else{
				     if($zd=='name'){
                         $sql_string.= " and user='".$key."'";
				     }else{
                         $sql_string.= " and uid=".intval($key)."";
				     }
				 }
			}

	        $sql_string.= " order by addtime desc";
            $count_sql = str_replace('*','count(*) as count',$sql_string);
	        $query = $this->db->query($count_sql)->result_array();
	        $total = $query[0]['count'];

            $base_url = site_url('admin/pl')."?zd=".$zd."&dir=".$dir."&key=".$key;
	        $per_page = 15; 
            $totalPages = ceil($total / $per_page); // 总页数
	        $data['nums'] = $total;
            if($total<$per_page){
                  $per_page=$total;
            }
            $sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
	        $query = $this->db->query($sql_string);

	        $data['pl'] = $query->result();
	        $data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类

            $this->load->view('pl.html',$data);
	}

    //删除评论
	public function del()
	{
            $id = $this->input->get_post('id',true);
			if(empty($id)) admin_msg(L('plub_01'),'javascript:history.back();','no');  //数据不完成
            $this->MsdjDB->get_del('pl',$id);
            admin_msg(L('plub_02'),site_url('admin/pl'),'ok');  //操作成功
	}
}

