<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2016 msvod.cc. All rights reserved.
 * @Author:Msvod By 
 * @Dtime:2014-04-27
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 电子口令卡类
 */
class Card {

  		public function __construct() {

			   $this->url="http://card.msvod.cc/index.php/home/";
  		}

        //远程获取KEY
        public function keys($admin) {
			    $url=$this->url.'keys?code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'version' => MS_Version,
			    )));
                $key=$this->get_url($url);
				return $key;
		}

        //申请口令卡
        public function add($admin) {
                $key=$this->keys($admin);
			    $url=$this->url.'add?key='.$key.'&code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'version' => MS_Version,
			    )));
                $code=$this->get_url($url);
				return $code;
		}

        //解除口令卡
        public function del($admin) {
                $key=$this->keys($admin);
			    $url=$this->url.'del?key='.$key.'&code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'version' => MS_Version,
			    )));
                $code=$this->get_url($url);
				return $code;
		}

        //获取口令卡图片地址
        public function pic($code,$admin) {
                $key=$this->keys($admin);
			    $url=$this->url.'?key='.$key.'&sn='.$code.'&code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'version' => MS_Version,
			    )));
                $pic_url=$this->get_url($url);
				return $pic_url;
		}

        //请求口令验证
        public function authe_rand($admin) {
                $key=$this->keys($admin);
			    $url=$this->url.'authe?key='.$key.'&code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'version' => MS_Version,
			    )));
                $zb_arr=$this->get_url($url);
				return $zb_arr;
		}

        //验证动态口令
        public function verification($admin,$rand,$code) {
                $key=$this->keys($admin);
			    $url=$this->url.'verification?key='.$key.'&code='.ms_base64_encode(arraystring(array(
			           'host' => Web_Url,
			           'name' => Web_Name,
			           'admin' => $admin,
			           'code' => $code,
			           'rand' => $rand,
			           'version' => MS_Version,
			    )));
                $str=$this->get_url($url);
				return $str;
		}

        //获取远程内容
        public function get_url($url) {
                $arr=htmlall($url);
				if(empty($arr)){
                     admin_msg(L('curl_err'),@$_SERVER['HTTP_REFERER'],'no');  //获取远程失败
				}else{

			         $arr = json_decode($arr, true);
                     $arr=get_bm($arr);
					 if($arr['status']==0){
                           admin_msg($arr['msg'],@$_SERVER['HTTP_REFERER'],'no');  //错误状态
					 }else{
				           return $arr['msg'];
					 }
				}
		}
}
