<?php if ( ! defined('IS_ADMIN')) exit('No direct script access allowed');
/**
* @Msvod v.6 open source management system
* @copyright 2009-2014 msvod.cc. All rights reserved.
* @Author:Msvod By 
* @Dtime:2014-12-16
*/
class Video extends msvod_Controller {

function __construct(){
parent::__construct();
$this->load->helper('Video');
$this->load->model('MsdjAdmin');
$this->MsdjAdmin->Admin_Login();
}

public function index()
{
$sort = $this->input->get_post('sort',true);
$desc = $this->input->get_post('desc',true);
$cid  = intval($this->input->get_post('cid'));
$fid  = intval($this->input->get_post('fid'));
$yid  = intval($this->input->get_post('yid'));
$reco = intval($this->input->get_post('reco'));
$zd   = $this->input->get_post('zd',true);
$key  = $this->input->get_post('key',true);
$page = intval($this->input->get('page'));
if($page==0) $page=1;

$data['page'] = $page;
$data['sort'] = $sort;
$data['cid'] = $cid;
$data['yid'] = $yid;
$data['fid'] = $fid;
$data['zd'] = $zd;
$data['key'] = $key;
$data['reco'] = $reco;
if(empty($sort)) $sort="addtime";

$sql_string = "SELECT id,name,pic,hits,hid,reco,singerid,cid,yid,uid,addtime FROM ".MS_SqlPrefix."video where 1=1";
if($yid==1){
$sql_string.= " and yid=0";
}
if($yid==2){
$sql_string.= " and yid=1";
}
if($yid==3){
$sql_string.= " and hid=1";
}else{
$sql_string.= " and hid=0";
}
if($fid>0){
$sql_string.= " and fid=".$fid."";
}
if($cid>0){
$sql_string.= " and cid=".$cid."";
}
if(!empty($key)){
if($zd=='user'){
$uid=getzd('user','id',$key,'name');
$sql_string.= " and uid='".intval($uid)."'";
}elseif($zd=='singer'){
$singerid=getzd('singer','id',$key,'name');
$sql_string.= " and singerid='".intval($singerid)."'";
}elseif($zd=='id'){
$sql_string.= " and id='".intval($key)."'";
}else{
$sql_string.= " and ".$zd." like '%".$key."%'";
}
}
if($reco>0){
$sql_string.= " and reco=".$reco."";
}
$sql_string.= " order by ".$sort." desc";
$count_sql = str_replace('id,name,pic,hits,hid,reco,singerid,cid,yid,uid,addtime','count(*) as count',$sql_string);
$query = $this->db->query($count_sql)->result_array();
$total = $query[0]['count'];

$base_url = site_url('video/admin/video')."?yid=".$yid."&zd=".$zd."&key=".$key."&cid=".$cid."&fid=".$fid."&sort=".$sort."&reco=".$reco;
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

$this->load->view('video.html',$data);
}

//推荐、锁定操作
public function init()
{
$ac  = $this->input->get_post('ac',true);
$id   = intval($this->input->get_post('id'));
$sid  = intval($this->input->get_post('sid'));
if($ac=='zt'){ //审核
$edit['yid']=$sid;
if($sid==0) $this->dt($id);
$str=($sid==0)?'<a title="'.L('plub_01').'" href="javascript:get_cmd(\''.site_url('video/admin/video/init').'?sid=1\',\'zt\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/ok.gif" /></a>':'<a title="'.L('plub_02').'" href="javascript:get_cmd(\''.site_url('video/admin/video/init').'?sid=0\',\'zt\','.$id.');"><img align="absmiddle" src="'.Web_Path.'packs/admin/images/icon/no.gif" /></a>';
}elseif($ac=='tj'){  //推荐
$edit['reco']=$sid;
$str='<a title="'.L('plub_03').'" href="javascript:get_cmd(\''.site_url('video/admin/video/init').'?sid=0\',\'tj\','.$id.');"><font color="#ff0033">×</font></a>';
for($i=1;$i<=$sid;$i++){
$str.='<a title="'.vsprintf(L('plub_04'),array($i)).'" href="javascript:get_cmd(\''.site_url('video/admin/video/init').'?sid='.$i.'\',\'tj\','.$id.');">★</a>';
}
for($j=$sid+1;$j<=5;$j++){
$str.='<a title="'.vsprintf(L('plub_04'),array($j)).'" href="javascript:get_cmd(\''.site_url('video/admin/video/init').'?sid='.$j.'\',\'tj\','.$id.');">☆</a>';
}
}
$this->MsdjDB->get_update('video',$id,$edit);
die($str);
}

//视频新增、修改
public function edit()
{
$id   = intval($this->input->get('id'));
if($id==0){
$data['id']=0;
$data['cid']=0;
$data['yid']=0;
$data['tid']=0;
$data['reco']=0;
$data['uid']=0;
$data['fid']=0;
$data['name']='';
$data['pic']='';
$data['lrc']='';
$data['color']='';
$data['cion']=0;
$data['dcion']=0;
$data['vip']=0;
$data['level']=0;
$data['tags']='';
$data['hits']=0;
$data['yhits']=0;
$data['zhits']=0;
$data['rhits']=0;
$data['dhits']=0;
$data['chits']=0;
$data['shits']=0;
$data['xhits']=0;
$data['zc']='';
$data['zq']='';
$data['bq']='';
$data['hy']='';
$data['singerid']=0;
$data['dx']='';
$data['yz']='';
$data['sc']='';
$data['text']='';
$data['purl']='';
$data['durl']='';
$data['wpurl']='';
$data['wppass']='';
$data['skins']='play.html';
$data['title']='';
$data['keywords']='';
$data['description']='';
}else{
$row=$this->db->query("SELECT * FROM ".MS_SqlPrefix."video where id=".$id."")->row(); 
if(!$row) admin_msg(L('plub_05'),'javascript:history.back();','no');  //记录不存在

$data['id']=$row->id;
$data['cid']=$row->cid;
$data['yid']=$row->yid;
$data['tid']=$row->tid;
$data['fid']=$row->fid;
$data['reco']=$row->reco;
$data['uid']=$row->uid;
$data['name']=$row->name;
$data['pic']=$row->pic;
$data['lrc']=$row->lrc;
$data['color']=$row->color;
$data['cion']=$row->cion;
$data['dcion']=$row->dcion;
$data['vip']=$row->vip;
$data['level']=$row->level;
$data['tags']=$row->tags;
$data['hits']=$row->hits;
$data['yhits']=$row->yhits;
$data['zhits']=$row->zhits;
$data['rhits']=$row->rhits;
$data['dhits']=$row->dhits;
$data['chits']=$row->chits;
$data['shits']=$row->shits;
$data['xhits']=$row->xhits;
$data['zc']=$row->zc;
$data['zq']=$row->zq;
$data['bq']=$row->bq;
$data['hy']=$row->hy;
$data['singerid']=$row->singerid;
$data['dx']=$row->dx;
$data['yz']=$row->yz;
$data['sc']=$row->sc;
$data['text']=$row->text;
$data['purl']=$row->purl;
$data['durl']=$row->durl;
$data['wpurl']=$row->wpurl;
$data['wppass']=$row->wppass;
$data['skins']=$row->skins;
$data['title']=$row->title;
$data['keywords']=$row->keywords;
$data['description']=$row->description;
}
$this->load->view('video_edit.html',$data);
}

//视频保存
public function save()
{
$id   = intval($this->input->post('id'));
$name = $this->input->post('name',true);
$user = $this->input->post('user',true);
$singer = $this->input->post('singer',true);
$tags = $this->input->post('tags',true);
$lrc = $this->input->post('lrc',true);
$text = remove_xss($this->input->post('text'));
$addtime = $this->input->post('addtime',true);
$data['cid']=intval($this->input->post('cid'));

if(empty($name)||empty($data['cid'])){
admin_msg(L('plub_06'),'javascript:history.back();','no');
}

//自动获取TAGS标签
if(empty($tags)){
$tags = gettag($name);
}

$data['fid']=intval($this->input->post('fid'));
$data['yid']=intval($this->input->post('yid'));
$data['tid']=intval($this->input->post('tid'));
$data['reco']=intval($this->input->post('reco'));
$data['uid']=intval(getzd('user','id',$user,'name'));
$data['name']=$name;
$data['pic']=$this->input->post('pic',true);
$data['lrc']=$lrc;
$data['text']=$text;
$data['color']=$this->input->post('color',true);
$data['cion']=intval($this->input->post('cion'));
$data['dcion']=intval($this->input->post('dcion'));
$data['vip']=intval($this->input->post('vip'));
$data['level']=intval($this->input->post('level'));
$data['tags']=$tags;
$data['hits']=intval($this->input->post('hits'));
$data['yhits']=intval($this->input->post('yhits'));
$data['zhits']=intval($this->input->post('zhits'));
$data['rhits']=intval($this->input->post('rhits'));
$data['dhits']=intval($this->input->post('dhits'));
$data['chits']=intval($this->input->post('chits'));
$data['shits']=intval($this->input->post('shits'));
$data['xhits']=intval($this->input->post('xhits'));
$data['zc']=$this->input->post('zc',true);
$data['zq']=$this->input->post('zq',true);
$data['bq']=$this->input->post('bq',true);
$data['hy']=$this->input->post('hy',true);
$data['singerid']=intval(getzd('singer','id',$singer,'name'));
$data['dx']=$this->input->post('dx',true);
$data['yz']=$this->input->post('yz',true);
$data['sc']=$this->input->post('sc',true);
$data['purl']=$this->input->post('purl',true);
$data['durl']=$this->input->post('durl',true);
$data['wpurl']=$this->input->post('wpurl',true);
$data['wppass']=$this->input->post('wppass',true);
$data['skins']=$this->input->post('skins',true);
$data['title']=$this->input->post('title',true);
$data['keywords']=$this->input->post('keywords',true);
$data['description']=$this->input->post('description',true);

if($id==0){ //新增
$data['addtime']=time();
$this->MsdjDB->get_insert('video',$data);
}else{
if($data['yid']==0) $this->dt($id);
if($addtime=='ok') $data['addtime']=time();
$this->MsdjDB->get_update('video',$id,$data);
}
admin_msg(L('plub_07'),site_url('video/admin/video'),'ok');  //操作成功
}

//视频删除
public function del()
{
$yid = intval($this->input->get('yid'));
$ids = $this->input->get_post('id');
$ac = $this->input->get_post('ac');
//回收站
if($ac=='hui'){
$result=$this->db->query("SELECT id,pic,purl FROM ".MS_SqlPrefix."video where hid=1")->result();
$this->load->library('msup');
foreach ($result as $row) {
if(!empty($row->pic)){
$this->msup->del($row->pic,'video'); //删除图片
}
if(!empty($row->purl)){
$this->msup->del($row->purl,'look'); //删除视频播放文件
}
$this->MsdjDB->get_del('video',$row->id);
}
admin_msg(L('plub_08'),'javascript:history.back();','ok');  //操作成功
}
if(empty($ids)) admin_msg(L('plub_09'),'javascript:history.back();','no');
if(is_array($ids)){
$idss=implode(',', $ids);
}else{
$idss=$ids;
}
if($yid==3){
$result=$this->db->query("SELECT pic,purl FROM ".MS_SqlPrefix."video where id in(".$idss.")")->result();
$this->load->library('msup');
foreach ($result as $row) {
if(!empty($row->pic)){
$this->msup->del($row->pic,'video'); //删除图片
}
if(!empty($row->purl)){
$this->msup->del($row->purl,'look'); //删除视频播放文件
}
}
$this->MsdjDB->get_del('video',$ids);
admin_msg(L('plub_10'),'javascript:history.back();','ok');  //操作成功
}else{
//减去金币、经验
if(is_array($ids)){
foreach ($ids as $id) $this->dt($id,1);
}else{
$this->dt($ids,1);
}
$data['hid']=1;
$this->MsdjDB->get_update('video',$ids,$data);//删除动态
admin_msg(L('plub_11'),'javascript:history.back();','ok');  //操作成功
}
}

//视频还原
public function hy()
{
$ids = $this->input->get_post('id');
if(empty($ids)) admin_msg(L('plub_12'),'javascript:history.back();','no');
if(is_array($ids)){
$idss=implode(',', $ids);
}else{
$idss=$ids;
}
$data['hid']=0;
$this->MsdjDB->get_update('video',$ids,$data);
admin_msg(L('plub_13'),'javascript:history.back();','ok');  //操作成功
}

//视频批量
public function pledit()
{
$data['id'] = $this->input->get_post('id');
$this->load->view('pl_edit.html',$data);
}

//批量修改操作
public function pl_save()
{
$xid=intval($this->input->post('xid'));
$csid=$this->input->post('csid');
$id=$this->input->post('id',true);
$cids=intval($this->input->post('cids'));

$fid=intval($this->input->post('fid'));
$cid=intval($this->input->post('cid'));
$hid=intval($this->input->post('hid'));
$tid=intval($this->input->post('tid'));
$yid=intval($this->input->post('yid'));
$user=$this->input->post('user',true);
$singer=$this->input->post('singer',true);
$skins=$this->input->post('skins',true);
$reco=intval($this->input->post('reco'));
$cion=intval($this->input->post('cion'));
$dcion=intval($this->input->post('dcion'));
$vip=intval($this->input->post('vip'));
$hits=intval($this->input->post('hits'));
$yhits=intval($this->input->post('yhits'));
$zhits=intval($this->input->post('zhits'));
$rhits=intval($this->input->post('rhits'));

if(empty($csid)) admin_msg(L('plub_14'),'javascript:history.back();','no');

if($xid==1){  //按ID操作
if(empty($id)) admin_msg(L('plub_15'),'javascript:history.back();','no');
foreach ($csid as $v) {
if($v=="cid"){
$this->db->query("update ".MS_SqlPrefix."video set cid=".$cid." where id in (".$id.")");
}elseif($v=="yid"){
//增加金币、经验
if($yid==0){
if(is_array($id)){
foreach ($id as $ids) $this->dt($ids);
}else{
$this->dt($id);
}
}
$this->db->query("update ".MS_SqlPrefix."video set yid=".$yid." where id in (".$id.")");
}elseif($v=="fid"){
$this->db->query("update ".MS_SqlPrefix."video set fid=".$fid." where id in (".$id.")");
}elseif($v=="tid"){
$this->db->query("update ".MS_SqlPrefix."video set tid=".$tid." where id in (".$id.")");
}elseif($v=="reco"){
$this->db->query("update ".MS_SqlPrefix."video set reco=".$reco." where id in (".$id.")");
}elseif($v=="cion"){
$this->db->query("update ".MS_SqlPrefix."video set cion=".$cion." where id in (".$id.")");
}elseif($v=="dcion"){
$this->db->query("update ".MS_SqlPrefix."video set dcion=".$dcion." where id in (".$id.")");
}elseif($v=="vip"){
$this->db->query("update ".MS_SqlPrefix."video set vip=".$vip." where id in (".$id.")");
}elseif($v=="hits"){
$this->db->query("update ".MS_SqlPrefix."video set hits=".$hits." where id in (".$id.")");
}elseif($v=="yhits"){
$this->db->query("update ".MS_SqlPrefix."video set yhits=".$yhits." where id in (".$id.")");
}elseif($v=="zhits"){
$this->db->query("update ".MS_SqlPrefix."video set zhits=".$zhits." where id in (".$id.")");
}elseif($v=="rhits"){
$this->db->query("update ".MS_SqlPrefix."video set rhits=".$rhits." where id in (".$id.")");
}elseif($v=="skins"){
$this->db->query("update ".MS_SqlPrefix."video set skins='".$skins."' where id in (".$id.")");
}elseif($v=="user"){
$uid=intval(getzd('user','id',$user,'name'));
$this->db->query("update ".MS_SqlPrefix."video set uid=".$uid." where id in (".$id.")");
}elseif($v=="singer"){
$singerid=intval(getzd('singer','id',$singer,'name'));
$this->db->query("update ".MS_SqlPrefix."video set singerid=".$singerid." where id in (".$id.")");
}elseif($v=="hid"){
if($hid==2){
$this->MsdjDB->get_del('video',$id);
}else{
//删除金币、经验
if(is_array($id)){
foreach ($id as $ids) $this->dt($ids,1);
}else{
$this->dt($id,1);
}
$this->db->query("update ".MS_SqlPrefix."video set hid=".$hid." where id in (".$id.")");
}
}
}
}else{ //按分类操作
if(empty($cids)) admin_msg(L('plub_16'),'javascript:history.back();','no');
foreach ($csid as $v) {
if($v=="cid"){
$this->db->query("update ".MS_SqlPrefix."video set cid=".$cid." where cid in (".$cids.")");
}elseif($v=="yid"){
$this->db->query("update ".MS_SqlPrefix."video set yid=".$yid." where cid in (".$cids.")");
}elseif($v=="fid"){
$this->db->query("update ".MS_SqlPrefix."video set fid=".$fid." where cid in (".$cids.")");
}elseif($v=="tid"){
$this->db->query("update ".MS_SqlPrefix."video set tid=".$tid." where cid in (".$cids.")");
}elseif($v=="reco"){
$this->db->query("update ".MS_SqlPrefix."video set reco=".$reco." where cid in (".$cids.")");
}elseif($v=="cion"){
$this->db->query("update ".MS_SqlPrefix."video set cion=".$cion." where cid in (".$cids.")");
}elseif($v=="dcion"){
$this->db->query("update ".MS_SqlPrefix."video set dcion=".$dcion." where cid in (".$cids.")");
}elseif($v=="vip"){
$this->db->query("update ".MS_SqlPrefix."video set vip=".$vip." where cid in (".$cids.")");
}elseif($v=="hits"){
$this->db->query("update ".MS_SqlPrefix."video set hits=".$hits." where cid in (".$cids.")");
}elseif($v=="yhits"){
$this->db->query("update ".MS_SqlPrefix."video set yhits=".$yhits." where cid in (".$cids.")");
}elseif($v=="zhits"){
$this->db->query("update ".MS_SqlPrefix."video set zhits=".$zhits." where cid in (".$cids.")");
}elseif($v=="rhits"){
$this->db->query("update ".MS_SqlPrefix."video set rhits=".$rhits." where cid in (".$cids.")");
}elseif($v=="skins"){
$this->db->query("update ".MS_SqlPrefix."video set skins='".$skins."' where cid in (".$cids.")");
}elseif($v=="user"){
$uid=intval(getzd('user','id',$user,'name'));
$this->db->query("update ".MS_SqlPrefix."video set uid=".$uid." where cid in (".$cids.")");
}elseif($v=="singer"){
$singerid=intval(getzd('singer','id',$singer,'name'));
$this->db->query("update ".MS_SqlPrefix."video set singerid=".$singerid." where cid in (".$cids.")");
}elseif($v=="hid"){
if($hid==2){
$this->MsdjDB->get_del('video',$cids);
}else{
$this->db->query("update ".MS_SqlPrefix."video set hid=".$hid." where cid in (".$cids.")");
}
}
}
}
exit('<script type="text/javascript">
parent.location.href=parent.location.href;
parent.tip_cokes();
</script>');  //操作成功
}

//审核视频增加积分、经验、同时动态显示
public function dt($id,$sid=0)
{
$dt=$this->db->query("SELECT id,name,yid FROM ".MS_SqlPrefix."dt where link='".linkurl('play','id',$id,1,'video')."'")->row();
if($dt){
$uid=getzd('video','uid',$id);
if($sid>0){ //删除

$str='';
if(User_Jinyan_Del>0){
$jinyan=getzd('user','jinyan',$uid);
if( User_Jinyan_Del <= $jinyan){
$str['jinyan']=$jinyan-User_Jinyan_Del;
}
}
if(User_Cion_Del>0){
$cion=getzd('user','cion',$uid);
if( User_Jinyan_Del <= $jinyan){
$str['cion']=$cion-User_Cion_Del;
}
}
if($str!=''){
$this->MsdjDB->get_update('user',$uid,$str);
}
//发送视频删除通知
$add['uida']=$uid;
$add['uidb']=0;
$add['name']='视频被删除';
$add['neir']='您的视频《'.$dt->name.'》被删除，系统同时扣除您'.User_Cion_Del.'个金币，'.User_Jinyan_Del.'个经验';
$add['addtime']=time();
$this->MsdjDB->get_insert('msg',$add);
//删除动态
$this->MsdjDB->get_del('dt',$dt->id);

}elseif($dt->yid==1){ //审核

$addhits=getzd('user','addhits',$uid);
$str='';
if($addhits<User_Nums_Add){
$this->db->query("update ".MS_SqlPrefix."user set cion=cion+".User_Cion_Add.",jinyan=jinyan+".User_Jinyan_Add.",addhits=addhits+1 where id=".$uid."");
$str.=L('plub_99');
}
$this->db->query("update ".MS_SqlPrefix."dt set yid=0,addtime='".time()."' where id=".$dt->id."");
//发送视频审核通知
$add['uida']=$uid;
$add['uidb']=0;
$add['name']=L('plub_100');
$add['neir']=vsprintf(L('plub_101'),array($dt->name,$str));
$add['addtime']=time();
$this->MsdjDB->get_insert('msg',$add);
}
}
}
}
