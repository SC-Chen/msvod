<?php 
/**
 * @msvod 4.x open source management system
 * @copyright 2009-2015 msvod.cc. All rights reserved.
 * @Author:Cheng Jie
 * @Dtime:2014-11-25
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gbook extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
	}

    //留言
	public function index()
	{
            $this->MsdjTpl->gbook();
	}

    //留言列表
	public function lists($page=1)
	{
		    //关闭数据库缓存
            $this->db->cache_off();
		    $callback = $this->input->get('callback',true);
            $Mark_Text=$this->MsdjTpl->gbook_list($page);
			echo $callback."({str:".json_encode($Mark_Text)."})";
	}

    //新增留言
	public function add()
	{
		    //关闭数据库缓存
            $this->db->cache_off();
			$token=$this->input->post('token', TRUE);
			$add['neir']=$this->input->post('neir', TRUE);
			$add['neir']=filter(get_bm($add['neir']));
			if(User_BookFun==0){
                 $error='10000';
			}elseif(!get_token('gbook_token',1,$token)){
                 $error='10001';
			}elseif(empty($add['neir'])){
                 $error='10002';
			}else{

                $add['uidb']=isset($_SESSION['msvod__id'])?intval($_SESSION['msvod__id']):0;
			    $add['cid']=1;
			    $add['ip']=getip();
			    $add['addtime']=time();

                $ids=$this->MsdjDB->get_insert('gbook',$add);
			    if(intval($ids)==0){
                    $error='10003'; //失败
				}else{
                    //摧毁token
			        get_token('gbook_token',2);
                    $error='10004';
				}
			}
			$data['error']=$error;
			echo json_encode($data);
	}
}
