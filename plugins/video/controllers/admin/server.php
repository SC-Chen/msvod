<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-12-16
 */
class Server extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->helper('video');
		    $this->load->model('MsdjAdmin');
	        $this->MsdjAdmin->Admin_Login();
	}

    //��Ƶ��������
	public function index()
	{
            $sql_string = "SELECT * FROM ".MS_SqlPrefix."video_server order by id asc";
	        $query = $this->db->query($sql_string); 
	        $data['video_server'] = $query->result();
            $this->load->view('video_server.html',$data);
	}

    //�����޸�
	public function plsave()
	{
            $ids=$this->input->post('id', TRUE); 
            if(empty($ids)){
                    admin_msg(L('plub_69'),'javascript:history.back();','no');
			}
			foreach ($ids as $id) {
		            $data['name']=$this->input->post('name_'.$id, TRUE);
		            $data['purl']=$this->input->post('purl_'.$id, TRUE);
		            $data['durl']=$this->input->post('durl_'.$id, TRUE);
                    $this->MsdjDB->get_update('video_server',$id,$data);
			}
            admin_msg(L('plub_70'),site_url('video/admin/server'),'ok');  //�����ɹ�
	}

    //����ת�Ʒ���
	public function zhuan()
	{
            $ids = $this->input->get_post('id', TRUE);
            $cid = intval($this->input->get_post('cid')); 
            if(empty($ids)){
                    admin_msg(L('plub_69'),'javascript:history.back();','no');
			}
            if($cid==0){
                    admin_msg(L('plub_71'),'javascript:history.back();','no');
			}
			$ids=implode(',', $ids);
            $this->db->query("update ".MS_SqlPrefix."video set fid=".$fid." where fid in (".$ids.")");
            admin_msg(L('plub_70'),site_url('video/admin/server'),'ok');  //�����ɹ�
	}

    //��������
	public function save()
	{

            $data['name']=$this->input->get('name',true);
            $data['purl']=$this->input->get('purl',true);
            $data['durl']=$this->input->get('durl',true);
			$this->MsdjDB->get_insert('video_server',$data);
            admin_msg(L('plub_70'),site_url('video/admin/server'),'ok');  //�����ɹ�
	}

    //ɾ��
	public function del()
	{
            $ids = $this->input->get_post('id');
			if(empty($ids)) admin_msg(L('plub_73'),'javascript:history.back();','no');
			if(is_array($ids)){
			     $idss=implode(',', $ids);
			}else{
			     $idss=$ids;
			}
			$this->MsdjDB->get_del('video_server',$ids);
            admin_msg(L('plub_74'),'javascript:history.back();','ok');  //�����ɹ�
	}
}

