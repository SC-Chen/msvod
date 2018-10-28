<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
* @Msvod 4.x open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By QQ:
* @Dtime:2016-9-16
*/
class Daili_type extends Msvod_Controller {
function __construct(){
parent::__construct();
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
$this->lang->load('admin_user');
}
//提现银行分类管理
public function index()
{
$sql_string = "SELECT * FROM ".MS_SqlPrefix."daili_type order by id asc";
$query = $this->db->query($sql_string); 
$data['daili_type'] = $query->result();
$this->load->view('daili_type.html',$data);
}
//批量修改
public function plsave()
{
$ids=$this->input->post('id', TRUE); 
if(empty($ids)){
admin_msg(L('plub_69'),'javascript:history.back();','no');
}
foreach ($ids as $id) {
$data['name']=$this->input->post('name_'.$id, TRUE);
$this->MsdjDB->get_update('daili_type',$id,$data);
}
admin_msg('操作成功！',site_url('admin/admin/daili_type'),'ok');  //操作成功
}
 
//新增保存
public function save()
{
$data['name']=$this->input->get('name',true);
$this->MsdjDB->get_insert('daili_type',$data);
admin_msg('操作成功！',site_url('admin/admin/daili_type'),'ok');  //操作成功
}
//删除
public function del()
{
$ids = $this->input->get_post('id');
if(empty($ids)) admin_msg('至少选择一条','javascript:history.back();','no');
if(is_array($ids)){
$idss=implode(',', $ids);
}else{
$idss=$ids;
}
$this->MsdjDB->get_del('daili_tixian',$ids);
admin_msg('操作成功！','javascript:history.back();','ok');  //操作成功
}
//提现列表
public function lists()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$key  = $this->input->get_post('key',true);
$zid  = intval($this->input->get_post('zid',true));
$page = intval($this->input->get('page'));
if($page==0) $page=1;
if(empty($sort)) $sort="id";
if(empty($desc)) $desc="desc";
$data['page'] = $page;
$data['sort'] = $sort;
$data['desc'] = $desc;
$data['key'] = $key;
$data['zid'] = $zid;
$key=intval($key);
$sql_string = "SELECT * FROM ".MS_SqlPrefix."daili_tixian where 1=1";
if($key>0){
$sql_string.= " and uid=".$key."";
}
if($zid>0){
$sql_string.= " and zid=".$zid."";
}
$sql_string.= " order by ".$sort." ".$desc;
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];
$base_url = site_url('admin/daili_type/lists')."?key=".$key."&zid=".$zid."&sort=".$sort."&desc=".$desc;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);
$data['tixian'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类
$this->load->view('tixian.html',$data);
}
public function look()
{
$id = $this->input->get_post('id',true);
$row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."daili_tixian where id=".$id."")->row();
$rows=$this->db->query("SELECT * FROM ".MS_SqlPrefix."daili_type where id=".$row->cid."")->row();
echo'提现银行：'.$rows->cid.'<br>
提现账号：'.$row->text.'<br>
提现姓名：'.$row->name.'<br>
提现金额：'.$row->cino.' 元<br>
联系电话：'.$row->tell.'
';
}
public function edit()
{
$id = $this->input->get_post('id',true);
if(empty($id)) admin_msg('id不能为空','javascript:history.back();','no');
$data['zid']=2;
$this->MsdjDB->get_update('daili_tixian',$id,$data);
admin_msg('操作成功！','javascript:history.back();','ok');  //操作成功
}
}
