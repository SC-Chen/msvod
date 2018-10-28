<?php
// --------------------------------------------------
// 全局控制器
// --------------------------------------------------
class Msvod_Loader extends CI_Loader 
{

    public function __construct() 
    {
        parent::__construct();
    }


	public
	function get_templates( $dir = NULL, $plubs = 0, $skins = NULL, $ulog = 0 ) {
		if ( !defined( 'IS_ADMIN' ) && strpos( REQUEST_URI, 'index.php/install/' ) === FALSE && !file_exists( FCPATH . 'packs/install/plub_install.lock' ) ) {
			msg_txt( L( 'plub_no_instal' ), Web_Path . 'admin.php' );
		}
		if ( !defined( 'PLUBPATH' ) && $plubs == 0 ) { //系统默认视图路径
			$path = str_replace( "\\", "/", MSVOD );
			if ( !$dir ) {
				$dirs = 'tpl/skins/' . Web_Skins;
			} else {
				if ( $dir == 'user' ) {
					$dirs = 'tpl/' . $dir . '/' . User_Skins; //会员中心默认视图
				} elseif ( $dir == 'home' ) {
					if ( !empty( $skins ) ) {
						$dirs = 'tpl/' . $dir . '/' . $skins; //会员空间默认视图
					} else {
						$dirs = 'tpl/' . $dir . '/' . Home_Skins; //会员空间默认视图
					}
				} else {
					$dirs = 'tpl/' . $dir . '/'; //系统后台视图
				}
			}
			if ( defined( 'MOBILE' ) && Mobile_Is == 1 ) { //手机门户视图
				if ( $dir == 'user' ) {
					$dirs = 'tpl/mobile/' . Mobile_Skins . 'user/';
				} elseif ( $dir == 'home' ) {
					$dirs = 'tpl/mobile/' . Mobile_Skins . 'home/';
				} elseif ( $dir != 'admin' ) {
					$dirs = 'tpl/mobile/' . Mobile_Skins;
				}
			}
		} else { //版块视图路径
			$path = str_replace( "\\", "/", APPPATH );
			$dir_file = APPPATH . 'config/site.php';
			if ( $plubs == 1 && !defined( 'PLUBPATH' ) ) {
				define( 'PLUBPATH', $dir );
				$path = FCPATH . 'plugins/' . $dir . '/';
				$dir_file = FCPATH . 'plugins/' . $dir . '/config/site.php';
			}
			//$ak=getzd('plugins','ak',PLUBPATH,'dir');
			//if(empty($ak)) msg_txt(vsprintf(L('plub_key_err1'),array(PLUBPATH)),Web_Path);
			//$arrs=unarraystring(sys_auth($ak,'D'));
			//if($arrs=='' || empty($arrs['md5']) || md5(PLUBPATH.$arrs['key'].host_ym(1))!=$arrs['md5']) msg_txt(vsprintf(L('plub_key_err2'),array(PLUBPATH)),Web_Path);
			$dirs = 'tpl/skins/default/';
			if ( is_file( $dir_file ) ) {
				$plub = require $dir_file;
				if ( is_array( $plub ) ) {
					//后台视图
					if ( defined( 'IS_ADMIN' ) && $plubs < 2 ) {
						$dirs = 'tpl/admin/';
						//手机视图
					} elseif ( !defined( 'IS_ADMIN' ) && defined( 'MOBILE' ) && $plub[ 'Mobile_Is' ] == 1 ) {
						$dirs = 'tpl/mobile/' . $plub[ 'Mobile_Dir' ];
						if ( defined( 'HOMEPATH' ) ) {
							$dirs .= 'home/';
						}
						if ( defined( 'USERPATH' ) ) {
							$dirs .= 'user/';
						}
						//前台视图
					} else {
						if ( defined( 'HOMEPATH' ) ) {
							if ( $ulog == 1 )$path = str_replace( "\\", "/", MSVOD );
							if ( !empty( $skins ) ) {
								$dirs = 'tpl/home/' . $skins;
							} else {
								$dirs = 'tpl/home/' . Home_Skins;
							}
						} elseif ( defined( 'USERPATH' ) ) {
							$dirs = 'tpl/user/' . $plub[ 'User_Dir' ];
						} else {
							$dirs = 'tpl/skins/' . $plub[ 'Skins_Dir' ];
						}
					}
				}
			}
		}
		if ( substr( $dirs, -1 ) != '/' )$dirs .= '/';
		$this->_ci_view_paths = array( $path . $dirs => TRUE );
		return $this->_ci_view_paths;
	}
}
