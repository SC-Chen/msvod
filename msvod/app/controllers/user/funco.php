<?php 
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2015-03-07
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funco extends msvod_Controller {

	function __construct(){
		    parent::__construct();
		    $this->load->model('MsdjTpl');
		    $this->load->model('MsdjUser');
			$this->lang->load('user');
			$this->MsdjUser->User_Login();
	}

    //访客列表
	public function index()
	{
		    $op=$this->uri->segment(4); //分页
		    $page=intval($this->uri->segment(5)); //分页
			if(empty($op)) $op='you';
			//模板
			$tpl='funco.html';
			//URL地址
		    $url='funco/index/'.$op;
			//当前会员
		    $row=$this->MsdjDB->get_row_arr('user','*',$_SESSION['msvod__id']);
			if(empty($row['nichen'])) $row['nichen']=$row['name'];
			//SQL
            if($op=='you'){
                  $sqlstr = "select * from ".MS_SqlPrefix."funco where uida=".$_SESSION['msvod__id'];
			}else{
                  $sqlstr = "select * from ".MS_SqlPrefix."funco where uidb=".$_SESSION['msvod__id'];
			}
			$ids['uid']=$_SESSION['msvod__id'];
			$ids['uida']=$_SESSION['msvod__id'];
			$data=$data_content=$aliasname='';
            //装载模板
		    $template=$this->load->view($tpl,$data,true);
		    $Mark_Text=$this->skins->topandend($template);
		    $Mark_Text=str_replace("{msvod:title}",L('funco_01'),$Mark_Text);
		    $Mark_Text=str_replace("{msvod:keywords}",Web_Keywords,$Mark_Text);
		    $Mark_Text=str_replace("{msvod:description}",Web_Description,$Mark_Text);
		    $Mark_Text=str_replace("{msvod:fid}",$op,$Mark_Text); //当前使用的fid
		    //预先除了分页
		    $pagenum=getpagenum($Mark_Text);
	        preg_match_all('/{msvod:([\S]+)\s+(.*?pagesize=\"([\S]+)\".*?)}([\s\S]+?){\/msvod:\1}/',$Mark_Text,$page_arr);
		    if(!empty($page_arr) && !empty($page_arr[2])){

					       $fields=$page_arr[1][0]; //前缀名
				           //组装SQL数据
					       $sqlstr=$this->skins->msvod_sql($page_arr[1][0],$page_arr[2][0],$page_arr[0][0],$page_arr[3][0],'id',$ids,0,$sqlstr);
					       $nums=$this->db->query($sqlstr)->num_rows(); //总数量
					       $Arr=userpage($sqlstr,$nums,$page_arr[3][0],$pagenum,$url,$page);
			               if($nums>0){
					            $sorti=1;
							    $result_array=$this->db->query($Arr[0])->result_array();
					            foreach ($result_array as $row2) {
									 $datatmp='';
									 $uida=$row2['uida'];
									 $uidb=$row2['uidb'];
                                     if($op=='my'){
                                          $row2['uida']=$uidb;
                                          $row2['uidb']=$uida;
									 }
						             $datatmp=$this->skins->msvod_skins($fields,$page_arr[0][0],$page_arr[4][0],$row2,$sorti);
						             $sorti++;
						             $data_content.=$datatmp;
					            }
			               }
			               $Mark_Text=page_mark($Mark_Text,$Arr);	//分页解析
			               $Mark_Text=str_replace($page_arr[0][0],$data_content,$Mark_Text);
			}
		    unset($page_arr);
		    $Mark_Text=$this->skins->msvod_common($Mark_Text);
	        $Mark_Text=$this->skins->csskins($Mark_Text,$ids);
		    $Mark_Text=$this->skins->msvod_skins('user',$Mark_Text,$Mark_Text,$row);//解析当前数据标签
			$Mark_Text=$this->skins->msvodumenu($Mark_Text,$_SESSION['msvod__id']);
            $Mark_Text=$this->skins->template_parse($Mark_Text,true);
            echo $Mark_Text;
	}
}
