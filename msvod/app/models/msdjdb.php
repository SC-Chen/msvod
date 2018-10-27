<?php
/**
 * @Msvod v.6 open source management system
 * @copyright 2009-2014 msvod.cc. All rights reserved.
 * @Author:Msvod By
 * @Dtime:2014-05-27
 */
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class MsdjDB extends CI_Model {

	function __construct() {
		parent::__construct();
//加载数据库连接
		$this->load->database();
//加载当前模板目录
		if (!defined('PLUBPATH')) {
			if (defined('IS_ADMIN')) {
				//后台视图
				$this->load->get_templates('admin');
			} elseif (defined('HOMEPATH')) {
				//会员空间视图
				$this->load->get_templates('home');
			} elseif (defined('USERPATH')) {
				//会员中心视图
				$this->load->get_templates('user');
			} else {
				//默认视图
				$this->load->get_templates();
			}
		} else {
			//板块视图

			$this->load->get_templates(PLUBPATH);
		}
	}

//多条件查询
	function get_all($sql) {
		$query = $this->db->query($sql);
		return $query->result();
	}

//多条件查询总数量
	function get_allnums($sql = '') {
		if (!empty($sql)) {
			preg_match('/select\s*(.+)from/i', strtolower($sql), $sqlarr);
			if (!empty($sqlarr[1])) {
				$sql = str_replace($sqlarr[1], ' count(*) as counta ', strtolower($sql));
				$rows = $this->db->query($sql)->result_array();
				$nums = (int) $rows[0]['counta'];
			} else {
				$query = $this->db->query($sql);
				$nums = (int) $query->num_rows();
			}
		} else {
			$nums = 0;
		}
		return $nums;
	}

//查询总数量
	function get_nums($table, $czd = '', $arr = '') {
		$sql = "SELECT count(*) as count FROM " . MS_SqlPrefix . $table;
		if (!empty($czd) && !empty($arr)) {
			$this->db->where($czd, $arr);
			if (is_array($arr)) {
				$arr2 = array();
				for ($i = 0; $i < count($arr); $i++) {
					$arr2[] = $czd[$i] . "=" . $arr[$i];
				}
				if (!empty($arr2)) {
					$arr2 = implode(' and ', $arr2);
					$sql .= " where " . $arr2;
				}
			} else {
				$sql .= " where " . $czd . "=" . $arr;
			}
		}
		$rows = $this->db->query($sql)->result_array();
		$nums = (int) $rows[0]['counta'];
		return $nums;
	}

//按条件查询单一对象
	function get_row($table, $fzd = '*', $arr = '', $czd = 'id') {
		if ($czd && $arr) {
			$this->db->where($czd, $arr);
		}
		$this->db->select($fzd);
		$query = $this->db->get($table);
		return $query->row();
	}

//按条件查询单一对象
	function get_row_arr($table, $fzd = '*', $arr = '', $czd = 'id') {
		if ($czd && $arr) {
			$this->db->where($czd, $arr);
		}
		$this->db->select($fzd);
		$query = $this->db->get($table);
		return $query->row_array();
	}

//按条件查询
	function get_select($table, $czd = '', $fzd = '*', $arr = '') {
		if ($czd && $arr) {
			$this->db->where($czd, $arr);
		}
		$this->db->select($fzd);
		$query = $this->db->get($table);
		return $query->result();
	}

//增加
	function get_insert($table, $arr) {
		if ($arr) {
			$this->db->insert($table, $arr);
			$ids = $this->db->insert_id();
			if ($ids) {
//判断动态保留数量
				if ($table == 'dt' && User_Dtts > 0 && !empty($_SESSION['msvod__id'])) {
					$rows = $this->db->query("select count(*) as count from " . MS_SqlPrefix . "dt where uid=" . $_SESSION['msvod__id'] . "")->result_array();
					$nums = (int) $rows[0]['count'];
					if ($nums > User_Dtts) {
						$limit = $nums - User_Dtts;
						$this->db->query("DELETE FROM " . MS_SqlPrefix . "dt where uid=" . $_SESSION['msvod__id'] . " order by addtime asc LIMIT " . $limit);
					}
				}
//判断说说保留数量
				if ($table == 'blog' && User_Ssts > 0 && !empty($_SESSION['msvod__id'])) {
					$rows = $this->db->query("select count(*) as count from " . MS_SqlPrefix . "blog where uid=" . $_SESSION['msvod__id'] . "")->result_array();
					$nums = (int) $rows[0]['count'];
					if ($nums > User_Ssts) {
						$limit = $nums - User_Ssts;
						$this->db->query("DELETE FROM " . MS_SqlPrefix . "blog where uid=" . $_SESSION['msvod__id'] . " order by addtime asc LIMIT " . $limit);
					}
				}
//判断访客保留数量
				if ($table == 'funco' && User_Fkts > 0 && !empty($_SESSION['msvod__id'])) {
					$rows = $this->db->query("select count(*) as count from " . MS_SqlPrefix . "funco where uida=" . $_SESSION['msvod__id'] . "")->result_array();
					$nums = (int) $rows[0]['count'];
					if ($nums > User_Ssts) {
						$limit = $nums - User_Ssts;
						$this->db->query("DELETE FROM " . MS_SqlPrefix . "funco where uida=" . $_SESSION['msvod__id'] . " order by addtime asc LIMIT " . $limit);
					}
				}
//判断粉丝保留数量
				if ($table == 'fans' && User_Fsts > 0 && !empty($_SESSION['msvod__id'])) {
					$rows = $this->db->query("select count(*) as count from " . MS_SqlPrefix . "fans where uida=" . $_SESSION['msvod__id'] . "")->result_array();
					$nums = (int) $rows[0]['count'];
					if ($nums > User_Ssts) {
						$limit = $nums - User_Ssts;
						$this->db->query("DELETE FROM " . MS_SqlPrefix . "fans where uida=" . $_SESSION['msvod__id'] . " order by addtime asc LIMIT " . $limit);
					}
				}
//判断关注保留数量
				if ($table == 'friend' && User_Hyts > 0 && !empty($_SESSION['msvod__id'])) {
					$rows = $this->db->query("select count(*) as count from " . MS_SqlPrefix . "friend where uida=" . $_SESSION['msvod__id'] . "")->result_array();
					$nums = (int) $rows[0]['count'];
					if ($nums > User_Ssts) {
						$limit = $nums - User_Ssts;
						$this->db->query("DELETE FROM " . MS_SqlPrefix . "friend where uida=" . $_SESSION['msvod__id'] . " order by addtime asc LIMIT " . $limit);
					}
				}
			}
			return $ids;
		} else {
			return false;
		}
	}

//修改
	function get_update($table, $id, $arr, $zd = 'id') {
		if (!empty($id)) {
			if (is_array($id)) {
				$this->db->where_in($zd, $id);
			} else {
				$this->db->where($zd, intval($id));
			}
			if ($this->db->update($table, $arr)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

//删除
	function get_del($table, $ids, $zd = 'id') {
		if (is_array($ids)) {
			$this->db->where_in($zd, $ids);
		} else {
			$this->db->where($zd, intval($ids));
		}
		if ($this->db->delete($table)) {
			return true;
		} else {
			return false;
		}
	}

//创建表
	function get_table($sql) {
//创建数据库
		$conn = @mysqli_connect(MS_Sqlserver, MS_Sqluid, MS_Sqlpwd);
		if (!$conn) {
			$this->MsdjAdmin->Admin_Url('<font color=red>抱歉,数据库连接失败！</font>', 'javascript:history.back();');
			exit();
		}
		@mysqli_select_db($conn, MS_Sqlname);
		@mysqli_query( $conn,"SET NAMES " . MS_Sqlcharset . "");
		@mysqli_query( $conn,$sql);
	}

//获取任意字段信息
	function getzd($table, $ziduan, $id, $cha = 'id') {
		if ($table && $ziduan && $id) {
			$this->db->where($cha, $id);
			$this->db->select($ziduan);
			$row = $this->db->get($table)->row();
			if ($row) {
				return $row->$ziduan;
			} else {
				return "";
			}
		}
	}

//解析多个分类ID  如 cid=1,2,3,4,5,6
	function getchild($cid, $table) {
		if (!empty($cid)) {
			$ClassArr = explode(',', $cid);
			for ($i = 0; $i < count($ClassArr); $i++) {
				$sql = "select id from " . MS_SqlPrefix . $table . " where fid='$ClassArr[$i]'"; //sql语句的组织返回
				$result = $this->db->query($sql);
				if ($result) {
					foreach ($result->result() as $row) {
						$ClassArr[] = $row->id;
					}
				}
			}
			$cid = implode(',', $ClassArr);
		}
		return $cid;
	}
}
