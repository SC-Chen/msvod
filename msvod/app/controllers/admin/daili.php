<?php 
/**
* @Mscms 4.x open source management system
* @copyright 2008-2015 msvod.cc. All rights reserved.
* @Author:Msvod QQ:
* @Dtime:2014-11-19
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Daili extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
$this->lang->load('admin_user');
}
//会员列表
public function index()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$key  = intval($this->input->get_post('key',true));
$page = intval($this->input->get('page'));
if($page==0) $page=1;
if(empty($sort)) $sort="id";
if(empty($desc)) $desc="desc";
$data['page'] = $page;
$data['sort'] = $sort;
$data['desc'] = $desc;
$data['key'] = '';
if($key>0){
$data['key'] = $key;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."daili_xiaji where dlid=".$key."";
$sql_string.= " order by ".$sort." ".$desc;
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/daili')."?key=".$key."&sort=".$sort."&desc=".$desc;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['user'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
}else{
$data['user'] = '';
$data['pages'] = ''; //获取分页类
}
$this->load->view('daili.html',$data);
}
//会员列表
public function daili_index()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
$dlrz = intval($this->input->get_post('dlrz',true));
if($page==0) $page=1;
if(empty($sort)) $sort="id";
if(empty($desc)) $desc="desc";
$data['page'] = $page;
$data['sort'] = $sort;
$data['desc'] = $desc;
$data['key'] = $key;
$data['dlrz'] = $dlrz;
$sql_string = "SELECT * FROM ".MS_SqlPrefix."user where yid=0";
if($dlrz==0){
$sql_string.= " and dlrz in (1,2)";
}else{
$sql_string.= " and dlrz='".$dlrz."'";
}
if(!empty($key)){
$sql_string.= " and ".$zd."='".$key."'";
}
$sql_string.= " order by ".$sort." ".$desc;
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/daili/daili_index')."?key=".$key."&dlrz=".$dlrz."&sort=".$sort."&desc=".$desc;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['user'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('daili_index.html',$data);
}
//待审核会员列表
public function verify()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;
if(empty($sort)) $sort="id";
if(empty($desc)) $desc="desc";
$data['page'] = $page;
$data['sort'] = $sort;
$data['desc'] = $desc;
$sql_string = "SELECT id,name,email,regip,addtime FROM ".MS_SqlPrefix."user where dlrz=1  order by ".$sort." ".$desc;
$query = $this->db->query($sql_string); 
$total = $query->num_rows();
$base_url = site_url('admin/daili/verify')."?sort=".$sort."&desc=".$desc;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['user'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('daili_verify.html',$data);
}
//会员审核操作
public function verify_save()
{
$id = intval($this->input->get('id'));
$op = $this->input->get('op',true);
$row=$this->db->query("SELECT name,email FROM ".MS_SqlPrefix."user where id=".$id."")->row();
if($op=='ok'){ //通过
$edit['dlrz']=2;
$this->MsdjDB->get_update('user',$id,$edit);
$emailneir=vsprintf(L('plub_01'),array($row->name));
}else{  //拒绝
$edit['dlrz']=0;
$this->MsdjDB->get_update('user',$id,$edit);
$emailneir=vsprintf(L('plub_02'),array($row->name));
}
admin_msg('操作成功','javascript:history.back();');
}
//推荐、认证、锁定操作
public function init()
{
$ac  = $this->input->get_post('ac',true);
$id   = intval($this->input->get_post('id'));
//认证
$rzid  = intval($this->input->get_post('rzid'));
$str=($rzid==2)?'<a title="'.L('plub_15').'" href="javascript:get_cmd(\''.site_url('admin/daili/init').'?rzid=0\',\'rz\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/ok.gif" /></a>':'<a title="'.L('plub_16').'" href="javascript:get_cmd(\''.site_url('admin/daili/init').'?rzid=2\',\'rz\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/no.gif" /></a>';
if($rzid==2){$rzid=0;}else{$rzid=2;}
$edit['dlrz']=$rzid;
$this->MsdjDB->get_update('user',$id,$edit);
die($str);
}






}
