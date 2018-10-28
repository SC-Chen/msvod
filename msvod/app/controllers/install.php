<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Install extends msvod_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->get_templates('install');
		$all = explode("/", $_SERVER["REQUEST_URI"]);
		$dir = ($all[1] != 'index.php') ? $all[1] : '';
		$url = str_replace('//', '/', $_SERVER['HTTP_HOST'] . '/' . $dir . '/');
		$url = "http://" . $url;
		$installurl = $url . 'index.php/install/';
		define("install_path", $url);
		define("install_url", $installurl);
	}

	public function index() {
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
		} else {
			$data['install'] = 'no';
		}
		$this->load->view('temp_1.html', $data);
	}

	public function save1() {
		$data = '';
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
			$this->load->view('temp_1.html', $data);
		} else {
			$this->load->view('temp_2.html', $data);
		}
	}

	public function save2() {
		$data = '';
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
			$this->load->view('temp_1.html', $data);
		} else {
			$this->load->view('temp_3.html', $data);
		}
	}

	public function save3() {
		$data = '';
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
			$this->load->view('temp_1.html', $data);
		} else {
			$this->load->model('MsdjDB');
			//清空原表记录
			$tables = $this->db->list_tables();
			foreach ((array) $tables as $table) {
				if (strpos($table, MS_SqlPrefix) !== FALSE) {
					$this->db->query("DROP TABLE IF EXISTS `" . $table . "`");
				}
			}
			$conn = @mysqli_connect(MS_Sqlserver, MS_Sqluid, MS_Sqlpwd);
			@mysqli_select_db($conn, MS_Sqlname);
			@mysqli_query( $conn,"SET NAMES " . MS_Sqlcharset);
			//导入数据表
			$sql = read_file("./packs/install/msvod_table.sql");
			$sql = str_replace('{Prefix}', MS_SqlPrefix, $sql);
			$sqlarr = explode(";", $sql);
			$str = "";
			for ($i = 1; $i < count($sqlarr); $i++) {
				$datasql = explode("--", $sqlarr[$i]);
				$sql = explode("<msvod>", $sqlarr[$i]);
				if (!empty($sql[1])) {
					@mysqli_query( $conn,$sql[1]);
				}
				$str .= @$datasql[1];
			}
			//导入默认数据
			$sql = read_file("./packs/install/msvod_data.sql");
			$sql = str_replace('{Prefix}', MS_SqlPrefix, $sql);
			$sqlarr = explode("#msvod#", $sql);
			for ($i = 0; $i < count($sqlarr); $i++) {
				if (!empty($sqlarr[$i])) {
					@mysqli_query( $conn,$sqlarr[$i]);
				}
			}
			$data['str'] = str_replace('ms_', MS_SqlPrefix, $str);
			$this->load->get_templates('install');
			$this->load->view('temp_5.html', $data);
		}
	}

	public function save4() {
		$data = '';
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
			$this->load->view('temp_1.html', $data);
		} else {
			$path = str_replace('index.php/install/save4', '', $_SERVER['PHP_SELF']);
			$path = str_replace('index.php', '', $path);
			$path = str_replace('install/save4', '', $path);
			$path = str_replace('//', '/', $path);
			$data['web_path'] = $path;
			$this->load->view('temp_6.html', $data);
		}
	}

	public function save5() {
		$data = '';
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			$data['install'] = 'ok';
			$this->load->view('temp_1.html', $data);
		} else {
			$web_name = $this->input->post('web_name');
			$web_url = $this->input->post('web_url');
			$web_path = $this->input->post('web_path');
			$web_mode = $this->input->post('web_mode');
			$admin_name = $this->input->post('admin_name');
			$admin_pass = $this->input->post('admin_pass');
			$admin_code = $this->input->post('admin_code');
			$web_language = $this->input->post('web_language');

			if (empty($web_name) || empty($web_url) || empty($web_path) || empty($admin_name) || empty($admin_pass) || empty($admin_code)) {
				msg_url('<font color=red>请把数据填写完整！</font>', 'javascript:history.back();');
			}

			//修改配置文件
			$config = read_file("./msvod/lib/Ms_Config.php");
			$config = preg_replace("/'Web_Name','(.*?)'/", "'Web_Name','" . $web_name . "'", $config);
			$config = preg_replace("/'Web_Url','(.*?)'/", "'Web_Url','" . $web_url . "'", $config);
			$config = preg_replace("/'Web_Path','(.*?)'/", "'Web_Path','" . $web_path . "'", $config);
			$config = preg_replace("/'Web_Mode',(.*?)\)/", "'Web_Mode'," . $web_mode . ")", $config);
			$config = preg_replace("/'Admin_Code','(.*?)'/", "'Admin_Code','" . $admin_code . "'", $config);
			$config = preg_replace("/'MS_Language','(.*?)'/", "'MS_Language','" . $web_language . "'", $config);
			if (!write_file('./msvod/lib/Ms_Config.php', $config)) {
				msg_url('<font color=red>文件./msvod/lib/Ms_Config.php，没有写入权限！</font>', 'javascript:history.back();');
				exit();
			}
			//写入管理员
			$this->load->model('MsdjDB');
			$this->load->helper('string');
			$admin_code = random_string('alnum', 6);
			$data['adminname'] = $admin_name;
			$data['adminpass'] = md5(md5($admin_pass) . $admin_code);
			$data['admincode'] = $admin_code;
			$data['sid'] = 1;
			$this->MsdjDB->get_insert('admin', $data);

			if (!write_file('./packs/install/install.lock', 'msvod')) {
				msg_url('<font color=red>目录./packs/install/，没有写入权限！</font>', 'javascript:history.back();');
				exit();
			}
			$this->load->get_templates('install');
			$this->load->view('temp_7.html');
		}
	}

	public function dbtest() {
		if (file_exists(FCPATH . 'packs/install/install.lock')) {
			exit('4');
		} else {
			$dbdriver = rawurldecode($_GET['dbdriver']);
			$dbhost = rawurldecode($_GET['dbhost']);
			$dbuser = rawurldecode($_GET['dbuser']);
			$dbpwd = rawurldecode($_GET['dbpwd']);
			$dbname = rawurldecode($_GET['dbname']);
			$dbprefix = rawurldecode($_GET['dbprefix']);
			$conn = @mysqli_connect($dbhost, $dbuser, $dbpwd);
			if (!$conn) {
				exit('2');
			} else {
				if (!mysqli_select_db($conn, $dbname)) {
					if (!@mysqli_query($conn, "CREATE DATABASE `" . $dbname . "`")) {
						exit('3');
					}
				}
				if (mysqli_select_db($conn, $dbname)) {
					//修改数据库配置
					$this->load->helper('string');
					$MS_Encryption_Key = 'msvod_' . random_string('alnum', 10);
					//修改数据库配置文件
					$config = read_file("./msvod/lib/Ms_DB.php");
					$config = preg_replace("/'MS_Sqlserver','(.*?)'/", "'MS_Sqlserver','" . $dbhost . "'", $config);
					$config = preg_replace("/'MS_Sqlname','(.*?)'/", "'MS_Sqlname','" . $dbname . "'", $config);
					$config = preg_replace("/'MS_Sqluid','(.*?)'/", "'MS_Sqluid','" . $dbuser . "'", $config);
					$config = preg_replace("/'MS_Sqlpwd','(.*?)'/", "'MS_Sqlpwd','" . $dbpwd . "'", $config);
					$config = preg_replace("/'MS_Dbdriver','(.*?)'/", "'MS_Dbdriver','" . $dbdriver . "'", $config);
					$config = preg_replace("/'MS_SqlPrefix','(.*?)'/", "'MS_SqlPrefix','" . $dbprefix . "'", $config);
					$config = preg_replace("/'MS_Encryption_Key','(.*?)'/", "'MS_Encryption_Key','" . $MS_Encryption_Key . "'", $config);
					if (!write_file('./msvod/lib/Ms_DB.php', $config)) {
						exit('5');
					}

					$tables = array();
					$query = mysqli_query($conn,"SHOW TABLES FROM `" . $dbname . "`");
					while ($r = mysqli_fetch_row($query)) {
						$tables[] = $r[0];
					}
					if ($tables && in_array($dbprefix . 'plugins', $tables)) {
						exit('1');
					}
				}
				exit('0');
			}
		}
	}
}
