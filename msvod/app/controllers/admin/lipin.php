<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
* @Msvod v.6 open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-12-16
*/
class Lipin extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjAdmin');
	        $this->MsdjAdmin->Admin_Login();
			$this->lang->load('admin_user');
	}

public function index()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;

$data['page'] = $page;
$data['sort'] = $sort;
if(empty($sort)) $sort="addtime";

$sql_string = "SELECT * FROM ".MS_SqlPrefix."lipin_list where 1=1";
$sql_string.= " order by ".$sort." desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];

$base_url = site_url('admin/lipin/index')."?sort=".$sort;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);

$data['video'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类

$this->load->view('lipin.html',$data);
}
//兑换列表
public function lists()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$zid = intval($this->input->get_post('zid',true));
$page = intval($this->input->get('page'));
if($page==0) $page=1;
if($zid==0) $zid=3;
$data['page'] = $page;
$data['sort'] = $sort;
if(empty($sort)) $sort="addtime";

$sql_string = "SELECT * FROM ".MS_SqlPrefix."lipin_jilu where 1=1";
if($zid<3){
if($zid==2){
$sql_string .=" and zid=1";
}else{
$sql_string .=" and zid=0";
}
}
$sql_string.= " order by ".$sort." desc";
$count_sql = str_replace('*','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];

$base_url = site_url('admin/lipin/lists')."?sort=".$sort;
$per_page = 15; 
$totalPages = ceil($total / $per_page); // 总页数
$data['nums'] = $total;
if($total<$per_page){
$per_page=$total;
}
$sql_string.=' limit '. $per_page*($page-1) .','. $per_page;
$query = $this->db->query($sql_string);

$data['video'] = $query->result();
$data['pages'] = get_admin_page($base_url,$totalPages,$page,10); //获取分页类

$this->load->view('lipin-jilu.html',$data);
}


//礼品新增、修改
public function edit()
{
$id   = intval($this->input->get('id'));
if($id==0){
$data['id']=0;
$data['cid']=0;
$data['zid']=0;
$data['name']='';
$data['pic']='';
$data['nums']='';
$data['text']='';
$data['cion']=0;
}else{
$row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."lipin_list where id=".$id."")->row(); 
if(!$row) admin_msg(L('plub_05'),'javascript:history.back();','no');  //记录不存在

$data['id']=$row->id;
$data['cid']=$row->cid;
$data['zid']=$row->zid;
$data['name']=$row->name;
$data['pic']=$row->pic;
$data['nums']=$row->nums;
$data['text']=$row->text;
$data['cion']=$row->cion;
}
$this->load->view('lipin_edit.html',$data);
}

//礼品保存
public function save()
{
$id   = intval($this->input->post('id'));
$name = $this->input->post('name',true);
$addtime = $this->input->post('addtime',true);
$pic = $this->input->post('pic',true);
$cid   = intval($this->input->post('cid'));
$zid   = intval($this->input->post('zid'));
$cion   = intval($this->input->post('cion'));
$nums   = intval($this->input->post('nums'));
$text = remove_xss($this->input->post('text'));

if(empty($name)||empty($pic)||empty($text)){
admin_msg('礼品名称、图片、详情不能为空','javascript:history.back();','no');
}


$data['cid']=$cid;
$data['zid']=$zid;
$data['name']=$name;
$data['pic']=$pic;
$data['nums']=$nums;
$data['text']=$text;
$data['cion']=$cion;
if($id==0){ //新增
$data['addtime']=time();
$this->MsdjDB->get_insert('lipin_list',$data);
}else{
if($addtime=='ok') $data['addtime']=time();
$this->MsdjDB->get_update('lipin_list',$id,$data);
}
admin_msg('保存成功',site_url('admin/lipin/index'),'ok');  //操作成功
}

//礼品删除
public function del()
{
$ids = $this->input->get_post('id');

$result=$this->db->query("SELECT * FROM ".MS_SqlPrefix."lipin_list where id in(".$ids.")")->result();
$this->load->library('msup');
foreach ($result as $row) {
if(!empty($row->pic)){
$this->msup->del($row->pic,'lipin'); //删除图片
}
}
$this->MsdjDB->get_del('lipin_list',$ids);
admin_msg('操作成功','javascript:history.back();','ok');  //操作成功


}
//礼品新增、修改
public function cha()
{
$id=intval($this->input->get('id'));
$row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."lipin_jilu where id=".$id."")->row(); 
$data['id']=$row->id;
$data['cid']=$row->cid;
$data['zid']=$row->zid;
$data['name']=$row->name;
$data['pic']=$row->pic;
$data['nums']=$row->nums;
$data['text']=$row->text;
$data['cion']=$row->cion;
echo '
兑换礼品详情：<br>礼品名称：'.$row->name.'<br>礼品数量：'.$row->nums.'个<br>发货地址：'.$row->text.'
';
}
//礼品删除
public function guo()
{
$id = $this->input->get_post('id');
$data['zid']=1;
$this->MsdjDB->get_update('lipin_jilu',$id,$data);

admin_msg('操作成功','javascript:history.back();','ok');  //操作成功


}
}
