锘??php
header('Content-Type: text/html; charset=utf-8');
/**********************************/
/*                                */
/* 瀛ら洦鍦ㄧ嚎鏂囦欢绠＄悊绯荤粺 V1.3      */
/*                                */
/* 鍘熷垱浣滆€咃細瀛ら洦                 */
/* http://www.gidc.me             */
/* http://www.guyusoftware.com    */
/*                                */
/* V1.1                           */
/* 姹夊寲骞朵紭鍖栫▼搴忓唴閮ㄧ粨鏋?        */
/* 淇鐩綍涓嬫湁鏂囦欢鏃犳硶鍒犻櫎鐨勯棶棰?*/
/* 浼樺寲骞朵慨澶嶅嚭閿欑殑鏌ョ湅鏂囦欢缁勪欢   */
/* 瀹炵幇鍦ㄧ嚎瑙ｅ帇Zip鏂囦欢鐨勫姛鑳?     */
/* 瀹炵幇浠庡叾浠栫綉鍧€杩滅▼涓婁紶鐨勫姛鑳?  */
/* 瀹炵幇鍏ㄧ珯鎵撳寘鐨勫姛鑳?            */
/* 瀹炵幇鏁版嵁搴撴湰鍦板浠藉姛鑳?        */
/* 瀹炵幇杩滅▼涓婁紶鍒板叾浠朏TP鐨勫姛鑳?   */
/*                                */
/* V1.2                           */
/* 瀹炵幇鍦ㄧ嚎鍘嬬缉Zip鍔熻兘            */
/* 瀹炵幇鑷潃鍔熻兘閬垮厤琚涓夋柟婊ョ敤   */
/* 娣诲姞鑷潃鍔熻兘                   */
/* 浼樺寲鐢ㄦ埛浣撻獙                   */
/*                                */
/* V1.3                           */
/* 瀹炵幇鏉冮檺璇诲彇涓庝慨鏀瑰姛鑳?        */
/* 瀹屽杽瑙ｅ帇Zip鏂囦欢鍒板綋鍓嶇洰褰曞姛鑳? */
/*                                */
/* 婧愯嚜锛歰sfm Static              */
/*                                */
/**********************************/

/**********************************/
/* 璁剧疆璇存槑                       */
/*                                */
/* $adminfile - 鏂囦欢鍚?           */
/* $sitetitle - 绯荤粺鍚嶇О.         */
/* $filefolder - 绠＄悊鐩綍.        */
/* $user - 鐢ㄦ埛鍚?                */
/* $pass - 瀵嗙爜                   */
/* $tbcolor1 - 鏈煡               */
/* $tbcolor2 - 鍒楄〃鍐呭鑳屾櫙       */
/* $tbcolor3 - 鍒楄〃澶磋儗鏅?        */
/* $bgcolor1 - 椤甸潰鑳屾櫙.          */
/* $bgcolor2 - 澶栨棰滆壊.          */
/* $bgcolor3 - 鎸夐挳鍜屾鍐呭唴瀹?    */
/* $txtcolor1 - 鏂囨湰涓庡垝杩囬摼鎺?   */
/* $txtcolor2 - 閾炬帴.             */
/**********************************/

$adminfile = $SCRIPT_NAME;
$tbcolor1 = "#bacaee";
$tbcolor2 = "#daeaff";
$tbcolor3 = "#7080dd";
$bgcolor1 = "#ffffff";
$bgcolor2 = "#a6a6a6";
$bgcolor3 = "#003399";
$txtcolor1 = "#000000";
$txtcolor2 = "#003399";
$filefolder = "./";
$sitetitle = '瀛ら洦鍦ㄧ嚎鏂囦欢绠＄悊绯荤粺';
$user = 'admin';
$pass = 'admin';
$meurl = $_SERVER['PHP_SELF'];
$me = end(explode('/', $meurl));

$op = $_REQUEST['op'];
$folder = $_REQUEST['folder'];
while (preg_match('/\.\.\//', $folder)) {
	$folder = preg_replace('/\.\.\//', '/', $folder);
}

while (preg_match('/\/\//', $folder)) {
	$folder = preg_replace('/\/\//', '/', $folder);
}

if ($folder == '') {
	$folder = $filefolder;
} elseif ($filefolder != '') {
	if (!ereg($filefolder, $folder)) {
		$folder = $filefolder;
	}
}

/****************************************************************/
/* User identification                                          */
/*                                                              */
/* Looks for cookies. Yum.                                      */
/****************************************************************/

if ($_COOKIE['user'] != $user || $_COOKIE['pass'] != md5($pass)) {
	if ($_REQUEST['user'] == $user && $_REQUEST['pass'] == $pass) {
		setcookie('user', $user, time() + 60 * 60 * 24 * 1);
		setcookie('pass', md5($pass), time() + 60 * 60 * 24 * 1);
	} else {
		if ($_REQUEST['user'] == $user || $_REQUEST['pass']) {
			$er = true;
		}

		login($er);
	}
}

/****************************************************************/
/* function maintop()                                           */
/*                                                              */
/* Controls the style and look of the site.                     */
/* Recieves $title and displayes it in the title and top.       */
/****************************************************************/
function maintop($title, $showtop = true) {
	global $me, $sitetitle, $lastsess, $login, $viewing, $iftop, $bgcolor1, $bgcolor2, $bgcolor3, $txtcolor1, $txtcolor2, $user, $pass, $password, $debug, $issuper;
	echo "<html>\n<head>\n"
		. "<title>$sitetitle :: $title</title>\n"
		. "</head>\n"
		. "<body bgcolor=\"#ffffff\">\n"
		. "<style>\n"
		. "td { font-size : 80%;font-family : tahoma;color: $txtcolor1;font-weight: 700;}\n"
		. "A:visited {color: \"$txtcolor2\";font-weight: bold;text-decoration: underline;}\n"
		. "A:hover {color: \"$txtcolor1\";font-weight: bold;text-decoration: underline;}\n"
		. "A:link {color: \"$txtcolor2\";font-weight: bold;text-decoration: underline;}\n"
		. "A:active {color: \"$bgcolor2\";font-weight: bold;text-decoration: underline;}\n"
		. "textarea {border: 1px solid $bgcolor3 ;color: black;background-color: white;}\n"
		. "input.button{border: 1px solid $bgcolor3;color: black;background-color: white;}\n"
		. "input.text{border: 1px solid $bgcolor3;color: black;background-color: white;}\n"
		. "BODY {color: $txtcolor1; FONT-SIZE: 10pt; FONT-FAMILY: Tahoma, Verdana, Arial, Helvetica, sans-serif; scrollbar-base-color: $bgcolor2; MARGIN: 0px 0px 10px; BACKGROUND-COLOR: $bgcolor1}\n"
		. ".title {FONT-WEIGHT: bold; FONT-SIZE: 10pt; COLOR: #000000; TEXT-ALIGN: center; FONT-FAMILY: Verdana, Arial, Helvetica, sans-serif}\n"
		. ".copyright {FONT-SIZE: 8pt; COLOR: #000000; TEXT-ALIGN: left}\n"
		. ".error {FONT-SIZE: 10pt; COLOR: #AA2222; TEXT-ALIGN: left}\n"
		. "</style>\n\n";

	if ($viewing == "") {
		echo "<table cellpadding=10 cellspacing=10 bgcolor=$bgcolor1 align=center><tr><td>\n"
			. "<table cellpadding=1 cellspacing=1 bgcolor=$bgcolor2><tr><td>\n"
			. "<table cellpadding=5 cellspacing=5 bgcolor=$bgcolor1><tr><td>\n";
	} else {
		echo "<table cellpadding=7 cellspacing=7 bgcolor=$bgcolor1><tr><td>\n";
	}

	echo "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
		. "<tr><td align=\"left\"><font face=\"Arial\" color=\"black\" size=\"4\">$sitetitle</font><font size=\"3\" color=\"black\"> :: $title</font></td>\n"
		. "<tr><td width=650 style=\"height: 1px;\" bgcolor=\"black\"></td></tr>\n";

	if ($showtop) {
		echo "<tr><td><font size=\"2\">\n"
			. "<a href=\"" . $adminfile . "?op=home\" $iftop>涓婚〉</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=up\" $iftop>涓婁紶</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=cr\" $iftop>鍒涘缓</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=allz\" $iftop>鍏ㄧ珯澶囦唤</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=sqlb\" $iftop>鏁版嵁搴撳浠?/a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=ftpa\" $iftop>FTP鍔熻兘</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=killme&dename=" . $me . "&folder=./\">鑷潃</a>\n"
			. "<img src=pixel.gif width=7 height=1><a href=\"" . $adminfile . "?op=logout\" $iftop>閫€鍑?/a>\n";

		echo "<tr><td width=650 style=\"height: 1px;\" bgcolor=\"black\"></td></tr>\n";
	}
	echo "</table><br>\n";
}

/****************************************************************/
/* function login()                                             */
/*                                                              */
/* Sets the cookies and alows user to log in.                   */
/* Recieves $pass as the user entered password.                 */
/****************************************************************/
function login($er = false) {
	global $op;
	setcookie("user", "", time() - 60 * 60 * 24 * 1);
	setcookie("pass", "", time() - 60 * 60 * 24 * 1);
	maintop("鐧诲綍", false);

	if ($er) {
		echo "<font class=error>**閿欒: 涓嶆纭殑鐧诲綍淇℃伅.**</font><br><br>\n";
	}

	echo "<form action=\"" . $adminfile . "?op=" . $op . "\" method=\"post\">\n"
		. "<table><tr>\n"
		. "<td><font size=\"2\">鐢ㄦ埛鍚? </font>"
		. "<td><input type=\"text\" name=\"user\" size=\"18\" border=\"0\" class=\"text\" value=\"$user\">\n"
		. "<tr><td><font size=\"2\">瀵嗙爜: </font>\n"
		. "<td><input type=\"password\" name=\"pass\" size=\"18\" border=\"0\" class=\"text\" value=\"$pass\">\n"
		. "<tr><td colspan=\"2\"><input type=\"submit\" name=\"submitButtonName\" value=\"鐧诲綍\" border=\"0\" class=\"button\">\n"
		. "</table>\n"
		. "</form>\n";
	mainbottom();

}

/****************************************************************/
/* function home()                                              */
/*                                                              */
/* Main function that displays contents of folders.             */
/****************************************************************/
function home() {
	global $folder, $tbcolor1, $tbcolor2, $tbcolor3, $filefolder, $HTTP_HOST;
	maintop("涓婚〉");
	echo "<font face=\"tahoma\" size=\"2\"><b>\n"
		. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\" width=100%>\n";

	$content1 = "";
	$content2 = "";

	$count = "0";
	$style = opendir($folder);
	$a = 1;
	$b = 1;

	if ($folder) {
		if (ereg("/home/", $folder)) {
			$folderx = ereg_replace("$filefolder", "", $folder);
			$folderx = "http://" . $HTTP_HOST . "/" . $folderx;
		} else {
			$folderx = $folder;
		}
	}

	while ($stylesheet = readdir($style)) {
		if (strlen($stylesheet) > 40) {
			$sstylesheet = substr($stylesheet, 0, 40) . "...";
		} else {
			$sstylesheet = $stylesheet;
		}
		if ($stylesheet[0] != "." && $stylesheet[0] != "..") {
			if (is_dir($folder . $stylesheet) && is_readable($folder . $stylesheet)) {
				$content1[$a] = "<td>" . $sstylesheet . "</td>\n"
				. "<td> "
				//.disk_total_space($folder.$stylesheet)." Commented out due to certain problems
				 . "<td align=\"left\"><img src=pixel.gif width=5 height=1>" . substr(sprintf('%o', fileperms($folder . $stylesheet)), -4)
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=home&folder=" . $folder . $stylesheet . "/\">鎵撳紑</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=ren&file=" . $stylesheet . "&folder=$folder\">閲嶅懡鍚?/a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=z&dename=" . $stylesheet . "&folder=$folder\">鍘嬬缉</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=del&dename=" . $stylesheet . "&folder=$folder\">鍒犻櫎</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=mov&file=" . $stylesheet . "&folder=$folder\">绉诲姩</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=chm&file=" . $stylesheet . "&folder=$folder\">璁剧疆</a>\n"
					. "<td align=\"center\"> <tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";
				$a++;
			} elseif (!is_dir($folder . $stylesheet) && is_readable($folder . $stylesheet)) {
				$content2[$b] = "<td><a href=\"" . $folderx . $stylesheet . "\">" . $sstylesheet . "</a></td>\n"
				. "<td align=\"left\"><img src=pixel.gif width=5 height=1>" . filesize($folder . $stylesheet)
				. "<td align=\"left\"><img src=pixel.gif width=5 height=1>" . substr(sprintf('%o', fileperms($folder . $stylesheet)), -4)
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=edit&fename=" . $stylesheet . "&folder=$folder\">缂栬緫</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=ren&file=" . $stylesheet . "&folder=$folder\">閲嶅懡鍚?/a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=unz&dename=" . $stylesheet . "&folder=$folder\">瑙ｅ帇</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=del&dename=" . $stylesheet . "&folder=$folder\">鍒犻櫎</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=mov&file=" . $stylesheet . "&folder=$folder\">绉诲姩</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=chm&file=" . $stylesheet . "&folder=$folder\">璁剧疆</a>\n"
					. "<td align=\"center\"><a href=\"" . $adminfile . "?op=viewframe&file=" . $stylesheet . "&folder=$folder\">鏌ョ湅</a>\n"
					. "<tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";
				$b++;
			} else {
				echo "Directory is unreadable\n";
			}
			$count++;
		}
	}
	closedir($style);

	echo "娴忚鐩綍: $folder\n"
		. "<br>鏂囦欢鏁? " . $count . "<br><br>";

	echo "<tr bgcolor=\"$tbcolor3\" width=100%>"
		. "<td width=220>妗ｅ悕\n"
		. "<td width=65>澶у皬\n"
		. "<td width=35>鏉冮檺\n"
		. "<td align=\"center\" width=44>鎵撳紑\n"
		. "<td align=\"center\" width=58>閲嶅懡鍚峔n"
		. "<td align=\"center\" width=45>鍘嬬缉\n"
		. "<td align=\"center\" width=45>鍒犻櫎\n"
		. "<td align=\"center\" width=45>绉诲姩\n"
		. "<td align=\"center\" width=45>鏉冮檺\n"
		. "<td align=\"center\" width=45>鏌ョ湅\n"
		. "<tr height=\"2\"><td height=\"2\" colspan=\"3\">\n";

	for ($a = 1; $a < count($content1) + 1; $a++) {
		$tcoloring = ($a % 2) ? $tbcolor1 : $tbcolor2;
		echo "<tr bgcolor=" . $tcoloring . " width=100%>";
		echo $content1[$a];
	}

	for ($b = 1; $b < count($content2) + 1; $b++) {
		$tcoloring = ($a++ % 2) ? $tbcolor1 : $tbcolor2;
		echo "<tr bgcolor=" . $tcoloring . " width=100%>";
		echo $content2[$b];
	}

	echo "</table>";
	mainbottom();
}

/****************************************************************/
/* function up()                                                */
/*                                                              */
/* First step to Upload.                                        */
/* User enters a file and the submits it to upload()            */
/****************************************************************/

function up() {
	global $folder, $content, $filefolder;
	maintop("涓婁紶");

	echo "<FORM ENCTYPE=\"multipart/form-data\" ACTION=\"" . $adminfile . "?op=upload\" METHOD=\"POST\">\n"
		. "<font face=\"tahoma\" size=\"2\"><b>鏈湴涓婁紶 <br>鏂囦欢:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;涓婁紶鐩綍:</b></font><br><input type=\"File\" name=\"upfile\" size=\"20\" class=\"text\">\n"
		. "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"ndir\" size=1>\n"
		. "<option value=\"" . $filefolder . "\">" . $filefolder . "</option>";
	listdir($filefolder);
	echo $content
		. "</select><br>"
		. "<input type=\"submit\" value=\"涓婁紶\" class=\"button\">\n"
		. "</form>\n";
	echo "杩滅▼涓婁紶鏄粈涔堟剰鎬濓紵<br>杩滅▼涓婁紶鏄粠鍏朵粬鏈嶅姟鍣ㄨ幏鍙栨枃浠跺苟鐩存帴涓嬭浇鍒板綋鍓嶆湇鍔″櫒鐨勪竴绉嶅姛鑳姐€?br>绫讳技浜嶴SH鐨刉get鍔熻兘锛屽厤鍘绘垜浠笅杞藉啀鎵嬪姩涓婁紶鎵€娴垂鐨勬椂闂淬€?br><br>杩滅▼涓嬭浇鍦板潃:<form action=\"" . $adminfile . "?op=yupload\" method=\"POST\"><input name=\"url\" size=\"80\" /><input name=\"submit\" value=\"涓婁紶\" type=\"submit\" /></form>\n"
		. "浠ヤ笅涓哄鐢ㄤ笅杞藉湴鍧€锛氾紙璇锋墜鍔ㄥ鍒讹級"
		. "<br>Wordpress锛歨ttp://tool.gidc.me/file/wordpress.zip"
		. "<br>Typecho锛歨ttp://tool.gidc.me/file/typecho.zip"
		. "<br>EMBlog锛歨ttp://tool.gidc.me/file/emblog.zip<br><br>";
	mainbottom();
}

/****************************************************************/
/* function yupload()                                           */
/*                                                              */
/* Second step in wget file.                                    */
/* Saves the file to the disk.                                  */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/

function yupload($url, $folder = "./") {
	set_time_limit(24 * 60 * 60); // 璁剧疆瓒呮椂鏃堕棿
	$destination_folder = $folder . './'; // 鏂囦欢涓嬭浇淇濆瓨鐩綍锛岄粯璁や负褰撳墠鏂囦欢鐩綍
	if (!is_dir($destination_folder)) { // 鍒ゆ柇鐩綍鏄惁瀛樺湪
		mkdirs($destination_folder); // 濡傛灉娌℃湁灏卞缓绔嬬洰褰?
	}
	$newfname = $destination_folder . basename($url); // 鍙栧緱鏂囦欢鐨勫悕绉?
	$file = fopen($url, "rb"); // 杩滅▼涓嬭浇鏂囦欢锛屼簩杩涘埗妯″紡
	if ($file) {
		// 濡傛灉涓嬭浇鎴愬姛
		$newf = fopen($newfname, "wb"); // 杩滃湪鏂囦欢鏂囦欢
		if ($newf) // 濡傛灉鏂囦欢淇濆瓨鎴愬姛
		{
			while (!feof($file)) { // 鍒ゆ柇闄勪欢鍐欏叆鏄惁瀹屾暣
				fwrite($newf, fread($file, 1024 * 8), 1024 * 8); // 娌℃湁鍐欏畬灏辩户缁?
			}
		}

	}
	if ($file) {
		fclose($file); // 鍏抽棴杩滅▼鏂囦欢
	}
	if ($newf) {
		fclose($newf); // 鍏抽棴鏈湴鏂囦欢
	}
	maintop("杩滅▼涓婁紶");
	echo "鏂囦欢 " . $url . " 涓婁紶鎴愬姛.\n"
		. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	mainbottom();
	return true;
}

/****************************************************************/
/* function upload()                                            */
/*                                                              */
/* Second step in upload.                                      */
/* Saves the file to the disk.                                  */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function upload($upfile, $ndir) {

	global $folder;
	if (!$upfile) {
		error("鏂囦欢澶ぇ 鎴?鏂囦欢澶у皬绛変簬0");
	} elseif ($upfile['name']) {
		if (copy($upfile['tmp_name'], $ndir . $upfile['name'])) {
			maintop("涓婁紶");
			echo "鏂囦欢 " . $upfile['name'] . $folder . $upfile_name . " 涓婁紶鎴愬姛.\n";
			mainbottom();
		} else {
			printerror("鏂囦欢 $upfile 涓婁紶澶辫触.");
		}
	} else {
		printerror("璇疯緭鍏ユ枃浠跺悕.");
	}
}

/****************************************************************/
/* function allz()                                               */
/*                                                              */
/* First step in allzip.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function allz() {
	maintop("鍏ㄧ珯澶囦唤");
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
		. "<font class=error>**璀﹀憡: 杩欏皢杩涜鍏ㄧ珯鎵撳寘鎴恆llbackup.zip鐨勫姩浣? 濡傚瓨鍦ㄨ鏂囦欢锛岃鏂囦欢灏嗚瑕嗙洊!**</font><br><br>\n"
		. "纭畾瑕佽繘琛屽叏绔欐墦鍖?<br><br>\n"
		. "<a href=\"" . $adminfile . "?op=allzip\">纭畾</a> | \n"
		. "<a href=\"" . $adminfile . "?op=home\"> 鍙栨秷 </a>\n"
		. "</table>\n";
	mainbottom();
}

/****************************************************************/
/* function allzip()                                            */
/*                                                              */
/* Second step in unzip.                                       */
/****************************************************************/
function allzip() {
	maintop("鍏ㄧ珯澶囦唤");
	if (file_exists('allbackup.zip')) {
		unlink('allbackup.zip');} else {
	}
	class Zipper extends ZipArchive {
		public function addDir($path) {
			print 'adding ' . $path . '<br>';
			$this->addEmptyDir($path);
			$nodes = glob($path . '/*');
			foreach ($nodes as $node) {
				print $node . '<br>';
				if (is_dir($node)) {
					$this->addDir($node);
				} else if (is_file($node)) {
					$this->addFile($node);
				}
			}
		}
	}
	$zip = new Zipper;
	$res = $zip->open('allbackup.zip', ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addDir('.');
		$zip->close();
		echo '鍏ㄧ珯鍘嬬缉瀹屾垚锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	} else {
		echo '鍏ㄧ珯鍘嬬缉澶辫触锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	}
	mainbottom();
}

/****************************************************************/
/* function unz()                                               */
/*                                                              */
/* First step in unz.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function unz($dename) {
	global $folder;
	if (!$dename == "") {
		maintop("瑙ｅ帇");
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
			. "<font class=error>**璀﹀憡: 杩欏皢瑙ｅ帇 " . $folder . $dename . " 鍒?folder. **</font><br><br>\n"
			. "纭畾瑕佽В鍘?" . $folder . $dename . "?<br><br>\n"
			. "<a href=\"" . $adminfile . "?op=unzip&dename=" . $dename . "&folder=$folder\">纭畾</a> | \n"
			. "<a href=\"" . $adminfile . "?op=home\"> 鍙栨秷 </a>\n"
			. "</table>\n";
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function unzip()                                            */
/*                                                              */
/* Second step in unzip.                                       */
/****************************************************************/
function unzip($dename) {
	global $folder;
	if (!$dename == "") {
		maintop("瑙ｅ帇");
		$zip = new ZipArchive();
		if ($zip->open($folder . $dename) === TRUE) {
			$zip->extractTo('./' . $folder);
			$zip->close();
			echo $dename . " 宸茬粡琚В鍘?"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		} else {
			echo '鏃犳硶瑙ｅ帇鏂囦欢.'
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function del()                                               */
/*                                                              */
/* First step in delete.                                        */
/* Prompts the user for confirmation.                           */
/* Recieves $dename and ask for deletion confirmation.          */
/****************************************************************/
function del($dename) {
	global $folder;
	if (!$dename == "") {
		maintop("鍒犻櫎");
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
			. "<font class=error>**璀﹀憡: 杩欏皢姘镐箙鍒犻櫎 " . $folder . $dename . ". 杩欎釜鍔ㄤ綔鏄笉鍙繕鍘熺殑.**</font><br><br>\n"
			. "纭畾瑕佸垹闄?" . $folder . $dename . "?<br><br>\n"
			. "<a href=\"" . $adminfile . "?op=delete&dename=" . $dename . "&folder=$folder\">纭畾</a> | \n"
			. "<a href=\"" . $adminfile . "?op=home\"> 鍙栨秷 </a>\n"
			. "</table>\n";
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function delete()                                            */
/*                                                              */
/* Second step in delete.                                       */
/* Deletes the actual file from disk.                           */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function deltree($pathdir) {
	if (is_empty_dir($pathdir)) //濡傛灉鏄┖鐨?
	{
		rmdir($pathdir); //鐩存帴鍒犻櫎
	} else {
//鍚﹀垯璇昏繖涓洰褰曪紝闄や簡.鍜?.澶?
		$d = dir($pathdir);
		while ($a = $d->read()) {
			if (is_file($pathdir . '/' . $a) && ($a != '.') && ($a != '..')) {unlink($pathdir . '/' . $a);}
			//濡傛灉鏄枃浠跺氨鐩存帴鍒犻櫎
			if (is_dir($pathdir . '/' . $a) && ($a != '.') && ($a != '..')) {
//濡傛灉鏄洰褰?
				if (!is_empty_dir($pathdir . '/' . $a)) //鏄惁涓虹┖
				{
					//濡傛灉涓嶆槸锛岃皟鐢ㄨ嚜韬紝涓嶈繃鏄師鏉ョ殑璺緞+浠栦笅绾х殑鐩綍鍚?
					deltree($pathdir . '/' . $a);
				}
				if (is_empty_dir($pathdir . '/' . $a)) {
//濡傛灉鏄┖灏辩洿鎺ュ垹闄?
					rmdir($pathdir . '/' . $a);
				}
			}
		}
		$d->close();
	}
}
function is_empty_dir($pathdir) {
//鍒ゆ柇鐩綍鏄惁涓虹┖
	$d = opendir($pathdir);
	$i = 0;
	while ($a = readdir($d)) {
		$i++;
	}
	closedir($d);
	if ($i > 2) {return false;} else {
		return true;
	}

}

function delete($dename) {
	global $folder;
	if (!$dename == "") {
		maintop("鍒犻櫎");
		if (is_dir($folder . $dename)) {
			if (is_empty_dir($folder . $dename)) {
				rmdir($folder . $dename);
				echo $dename . " 宸茬粡琚垹闄?"
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			} else {
				deltree($folder . $dename);
				rmdir($folder . $dename);
				echo $dename . " 宸茬粡琚垹闄?"
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			}
		} else {
			if (unlink($folder . $dename)) {
				echo $dename . " 宸茬粡琚垹闄?"
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			} else {
				echo "鏃犳硶鍒犻櫎鏂囦欢. "
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			}
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function edit()                                              */
/*                                                              */
/* First step in edit.                                          */
/* Reads the file from disk and displays it to be edited.       */
/* Recieves $upfile from up() as the uploaded file.             */
/****************************************************************/
function edit($fename) {
	global $folder;
	if (!$fename == "") {
		maintop("缂栬緫");
		echo $folder . $fename;

		echo "<form action=\"" . $adminfile . "?op=save\" method=\"post\">\n"
			. "<textarea cols=\"73\" rows=\"40\" name=\"ncontent\">\n";

		$handle = fopen($folder . $fename, "r");
		$contents = "";

		while ($x < 1) {
			$data = @fread($handle, filesize($folder . $fename));
			if (strlen($data) == 0) {
				break;
			}
			$contents .= $data;
		}
		fclose($handle);

		$replace1 = "</text";
		$replace2 = "area>";
		$replace3 = "< / text";
		$replace4 = "area>";
		$replacea = $replace1 . $replace2;
		$replaceb = $replace3 . $replace4;
		$contents = ereg_replace($replacea, $replaceb, $contents);

		echo $contents;

		echo "</textarea>\n"
			. "<br><br>\n"
			. "<input type=\"hidden\" name=\"folder\" value=\"" . $folder . "\">\n"
			. "<input type=\"hidden\" name=\"fename\" value=\"" . $fename . "\">\n"
			. "<input type=\"submit\" value=\"淇濆瓨\" class=\"button\">\n"
			. "</form>\n";
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function save()                                              */
/*                                                              */
/* Second step in edit.                                         */
/* Recieves $ncontent from edit() as the file content.          */
/* Recieves $fename from edit() as the file name to modify.     */
/****************************************************************/
function save($ncontent, $fename) {
	global $folder;
	if (!$fename == "") {
		maintop("缂栬緫");
		$loc = $folder . $fename;
		$fp = fopen($loc, "w");

		$replace1 = "</text";
		$replace2 = "area>";
		$replace3 = "< / text";
		$replace4 = "area>";
		$replacea = $replace1 . $replace2;
		$replaceb = $replace3 . $replace4;
		$ncontent = ereg_replace($replaceb, $replacea, $ncontent);

		$ydata = stripslashes($ncontent);

		if (fwrite($fp, $ydata)) {
			echo "鏂囦欢 <a href=\"" . $adminfile . "?op=viewframe&file=" . $fename . "&folder=" . $folder . "\">" . $folder . $fename . "</a> 淇濆瓨鎴愬姛锛乗n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			$fp = null;
		} else {
			echo "鏂囦欢淇濆瓨鍑洪敊锛乗n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function cr()                                                */
/*                                                              */
/* First step in create.                                        */
/* Promts the user to a filename and file/directory switch.     */
/****************************************************************/
function cr() {
	global $folder, $content, $filefolder;
	maintop("鍒涘缓");
	if (!$content == "") {echo "<br><br>璇疯緭鍏ヤ竴涓悕绉?\n";}
	echo "<form action=\"" . $adminfile . "?op=create\" method=\"post\">\n"
		. "鏂囦欢鍚? <br><input type=\"text\" size=\"20\" name=\"nfname\" class=\"text\"><br><br>\n"

		. "鐩爣:<br><select name=ndir size=1>\n"
		. "<option value=\"" . $filefolder . "\">" . $filefolder . "</option>";
	listdir($filefolder);
	echo $content
		. "</select><br><br>";

	echo "鏂囦欢 <input type=\"radio\" size=\"20\" name=\"isfolder\" value=\"0\" checked><br>\n"
		. "鐩綍 <input type=\"radio\" size=\"20\" name=\"isfolder\" value=\"1\"><br><br>\n"
		. "<input type=\"hidden\" name=\"folder\" value=\"$folder\">\n"
		. "<input type=\"submit\" value=\"鍒涘缓\" class=\"button\">\n"
		. "</form>\n";
	mainbottom();
}

/****************************************************************/
/* function create()                                            */
/*                                                              */
/* Second step in create.                                       */
/* Creates the file/directoy on disk.                           */
/* Recieves $nfname from cr() as the filename.                  */
/* Recieves $infolder from cr() to determine file trpe.         */
/****************************************************************/
function create($nfname, $isfolder, $ndir) {
	global $folder;
	if (!$nfname == "") {
		maintop("鍒涘缓");

		if ($isfolder == 1) {
			if (mkdir($ndir . "/" . $nfname, 0777)) {
				echo "鎮ㄧ殑鐩綍<a href=\"" . $adminfile . "?op=home&folder=./" . $nfname . "/\">" . $ndir . "" . $nfname . "</a> 宸茬粡鎴愬姛琚垱寤?\n"
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			} else {
				echo "鎮ㄧ殑鐩綍" . $ndir . "" . $nfname . " 涓嶈兘琚垱寤? 璇锋鏌ユ偍鐨勭洰褰曟潈闄愭槸鍚﹀凡缁忚璁剧疆涓?77\n";
			}
		} else {
			if (fopen($ndir . "/" . $nfname, "w")) {
				echo "鎮ㄧ殑鏂囦欢, <a href=\"" . $adminfile . "?op=viewframe&file=" . $nfname . "&folder=$ndir\">" . $ndir . $nfname . "</a> 宸茬粡鎴愬姛琚垱寤?\n"
					. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
			} else {
				echo "鎮ㄧ殑鏂囦欢 " . $ndir . "/" . $nfname . " 涓嶈兘琚垱寤? 璇锋鏌ユ偍鐨勭洰褰曟潈闄愭槸鍚﹀凡缁忚璁剧疆涓?77\n";
			}
		}
		mainbottom();
	} else {
		cr();
	}
}

function chm($file) {
	global $folder;
	if (!$file == "") {
		maintop("璁剧疆鏉冮檺");
		echo "<form action=\"" . $adminfile . "?op=chmodok\" method=\"post\">\n"
			. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
			. "璁剧疆鏉冮檺 " . $folder . $file;

		echo "</table><br>\n"
			. "<input type=\"hidden\" name=\"rename\" value=\"" . $file . "\">\n"
			. "<input type=\"hidden\" name=\"folder\" value=\"" . $folder . "\">\n"
			. "鏉冮檺:<br><input class=\"text\" type=\"text\" size=\"20\" name=\"nchmod\">\n"
			. "<input type=\"Submit\" value=\"璁剧疆\" class=\"button\">\n";
		echo "<br><br>\n"
			. "鏉冮檺涓哄洓浣嶆暟锛屽0777 0755 0644绛塡n"
			. "<br>\n";
		mainbottom();
	} else {
		home();
	}
}

function chmodok($rename, $nchmod, $folder) {
	global $folder;
	if (!$rename == "") {
		maintop("閲嶅懡鍚?);
		$loc1 = "$folder" . $rename;
		$loc2 = octdec($nchmod);

		if (chmod($loc1, "$loc2")) {
			echo "鏂囦欢 " . $folder . $rename . " 鐨勬潈闄愬凡缁忚缃负" . $nchmod . "</a>\n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		} else {
			echo "璁剧疆鍑洪敊锛乗n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function ren()                                               */
/*                                                              */
/* First step in rename.                                        */
/* Promts the user for new filename.                            */
/* Globals $file and $folder for filename.                      */
/****************************************************************/
function ren($file) {
	global $folder;
	if (!$file == "") {
		maintop("閲嶅懡鍚?);
		echo "<form action=\"" . $adminfile . "?op=rename\" method=\"post\">\n"
			. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
			. "閲嶅懡鍚?" . $folder . $file;

		echo "</table><br>\n"
			. "<input type=\"hidden\" name=\"rename\" value=\"" . $file . "\">\n"
			. "<input type=\"hidden\" name=\"folder\" value=\"" . $folder . "\">\n"
			. "鏂版。鍚?<br><input class=\"text\" type=\"text\" size=\"20\" name=\"nrename\">\n"
			. "<input type=\"Submit\" value=\"閲嶅懡鍚峔" class=\"button\">\n";
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function renam()                                             */
/*                                                              */
/* Second step in rename.                                       */
/* Rename the specified file.                                   */
/* Recieves $rename from ren() as the old  filename.            */
/* Recieves $nrename from ren() as the new filename.            */
/****************************************************************/
function renam($rename, $nrename, $folder) {
	global $folder;
	if (!$rename == "") {
		maintop("閲嶅懡鍚?);
		$loc1 = "$folder" . $rename;
		$loc2 = "$folder" . $nrename;

		if (rename($loc1, $loc2)) {
			echo "鏂囦欢 " . $folder . $rename . " 鐨勬。鍚嶅凡琚洿鏀规垚 " . $folder . $nrename . "</a>\n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		} else {
			echo "閲嶅懡鍚嶅嚭閿欙紒\n"
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function listdir()                                           */
/*                                                              */
/* Recursivly lists directories and sub-directories.            */
/* Recieves $dir as the directory to scan through.              */
/****************************************************************/
function listdir($dir, $level_count = 0) {
	global $content;
	if (!@($thisdir = opendir($dir))) {return;}
	while ($item = readdir($thisdir)) {
		if (is_dir("$dir/$item") && (substr("$item", 0, 1) != '.')) {
			listdir("$dir/$item", $level_count + 1);
		}
	}
	if ($level_count > 0) {
		$dir = ereg_replace("[/][/]", "/", $dir);
		$content .= "<option value=\"" . $dir . "/\">" . $dir . "/</option>";
	}
}

/****************************************************************/
/* function mov()                                               */
/*                                                              */
/* First step in move.                                          */
/* Prompts the user for destination path.                       */
/* Recieves $file and sends to move().                          */
/****************************************************************/
function mov($file) {
	global $folder, $content, $filefolder;
	if (!$file == "") {
		maintop("绉诲姩");
		echo "<form action=\"" . $adminfile . "?op=move\" method=\"post\">\n"
			. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
			. "绉诲姩 " . $folder . $file . " 鍒?\n"
			. "<select name=ndir size=1>\n"
			. "<option value=\"" . $filefolder . "\">" . $filefolder . "</option>";
		listdir($filefolder);
		echo $content
			. "</select>"
			. "</table><br><input type=\"hidden\" name=\"file\" value=\"" . $file . "\">\n"
			. "<input type=\"hidden\" name=\"folder\" value=\"" . $folder . "\">\n"
			. "<input type=\"Submit\" value=\"绉诲姩\" class=\"button\">\n";
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function move()                                              */
/*                                                              */
/* Second step in move.                                         */
/* Moves the oldfile to the new one.                            */
/* Recieves $file and $ndir and creates $file.$ndir             */
/****************************************************************/
function move($file, $ndir, $folder) {
	global $folder;
	if (!$file == "") {
		maintop("绉诲姩");
		if (rename($folder . $file, $ndir . $file)) {
			echo $folder . $file . " 宸茬粡鎴愬姛绉诲姩鍒?" . $ndir . $file
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		} else {
			echo "鏃犳硶绉诲姩 " . $folder . $file
				. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function viewframe()                                         */
/*                                                              */
/* First step in viewframe.                                     */
/* Takes the specified file and displays it in a frame.         */
/* Recieves $file and sends it to viewtop                       */
/****************************************************************/
function viewframe($file) {
	global $sitetitle, $folder, $HTTP_HOST, $filefolder;
	if ($filefolder == "/") {
		$error = "**閿欒: 浣犻€夋嫨鏌ョ湅$file 浣嗕綘鐨勭洰褰曟槸 /.**";
		printerror($error);
		die();
	} elseif (ereg("/home/", $folder)) {
		$folderx = ereg_replace("$filefolder", "", $folder);
		$folder = "http://" . $HTTP_HOST . "/" . $folderx;
	}
	maintop("鏌ョ湅鏂囦欢", true);

	echo "<iframe width=\"99%\" height=\"99%\" src=\"" . $folder . $file . "\">\n"
		. "鏈珯浣跨敤浜嗘鏋舵妧鏈?浣嗘槸鎮ㄧ殑娴忚鍣ㄤ笉鏀寔妗嗘灦,璇峰崌绾ф偍鐨勬祻瑙堝櫒浠ヤ究姝ｅ父璁块棶鏈珯."
		. "</iframe>\n\n";
	mainbottom();
}

/****************************************************************/
/* function viewtop()                                           */
/*                                                              */
/* Second step in viewframe.                                    */
/* Controls the top bar on the viewframe.                       */
/* Recieves $file from viewtop.                                 */
/****************************************************************/
function viewtop($file) {
	global $viewing, $iftop;
	$viewing = "yes";
	$iftop = "target=_top";
	maintop("鏌ョ湅鏂囦欢 - $file");
}

/****************************************************************/
/* function logout()                                            */
/*                                                              */
/* Logs the user out and kills cookies                          */
/****************************************************************/
function logout() {
	global $login;
	setcookie("user", "", time() - 60 * 60 * 24 * 1);
	setcookie("pass", "", time() - 60 * 60 * 24 * 1);

	maintop("閫€鍑?, false);
	echo "浣犲凡缁忛€€鍑?"
		. "<br><br>"
		. "<a href=" . $adminfile . "?op=home>鐐瑰嚮杩欓噷閲嶆柊鐧诲綍.</a>";
	mainbottom();
}

/****************************************************************/
/* function mainbottom()                                        */
/*                                                              */
/* Controls the bottom copyright.                               */
/****************************************************************/
function mainbottom() {
	echo "</table></table>\n"
		. "<table width=100%><tr><td align=right><font class=copyright>Powered By <a href=http://www.guyusoftware.com>VPS鎺ㄨ崘</a> & <a href=http://www.gidc.me>瀛ら洦浜掕仈</a></font></table>\n"
		. "</table></table></body>\n"
		. "</html>\n";
	exit;
}

/****************************************************************/
/* function sqlb()                                              */
/*                                                              */
/* First step to backup sql.                                    */
/****************************************************************/

function sqlb() {
	maintop("鏁版嵁搴撳浠?);
	echo $content
		. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\"></table><font class=error>**璀﹀憡: 杩欏皢杩涜鏁版嵁搴撳鍑哄苟鍘嬬缉鎴恗ysql.zip鐨勫姩浣? 濡傚瓨鍦ㄨ鏂囦欢,璇ユ枃浠跺皢琚鐩?**</font><br><br><form action=\"" . $adminfile . "?op=sqlbackup\" method=\"POST\">鏁版嵁搴撳湴鍧€:&nbsp;&nbsp;<input name=\"ip\" size=\"30\" /><br>鏁版嵁搴撳悕绉?&nbsp;&nbsp;<input name=\"sql\" size=\"30\" /><br>鏁版嵁搴撶敤鎴?&nbsp;&nbsp;<input name=\"username\" size=\"30\" /><br>鏁版嵁搴撳瘑鐮?&nbsp;&nbsp;<input name=\"password\" size=\"30\" /><br>鏁版嵁搴撶紪鐮?&nbsp;&nbsp;<select id=\"chset\"><option id=\utf8\">utf8</option></select><br><input name=\"submit\" value=\"澶囦唤\" type=\"submit\" /></form>\n
";
	mainbottom();
}

/****************************************************************/
/* function sqlbackup()                                         */
/*                                                              */
/* Second step in backup sql.                                   */
/****************************************************************/
function sqlbackup($ip, $sql, $username, $password) {
	maintop("鏁版嵁搴撳浠?);
	$database = $sql; //鏁版嵁搴撳悕
	$options = array(
		'hostname' => $ip, //ip鍦板潃
		'charset' => 'utf8', //缂栫爜
		'filename' => $database . '.sql', //鏂囦欢鍚?
		'username' => $username,
		'password' => $password,
	);
	$conn = mysqli_connect($options['hostname'], $options['username'], $options['password']) or die("涓嶈兘杩炴帴鏁版嵁搴?");
	mysqli_select_db($conn, $database) or die("鏁版嵁搴撳悕绉伴敊璇?");
	mysqli_query($conn, "SET NAMES '{$options['charset']}'");
	$tables = list_tables($database);
	$filename = sprintf($options['filename'], $database);
	$fp = fopen($filename, 'w');
	foreach ($tables as $table) {
		dump_table($table, $fp);
	}
	fclose($fp);
//鍘嬬缉sql鏂囦欢
	if (file_exists('mysql.zip')) {
		unlink('mysql.zip');} else {
	}
	$file_name = $options['filename'];
	$zip = new ZipArchive;
	$res = $zip->open('mysql.zip', ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addfile($file_name);
		$zip->close();
//鍒犻櫎鏈嶅姟鍣ㄤ笂鐨剆ql鏂囦欢
		unlink($file_name);
		echo '鏁版嵁搴撳鍑哄苟鍘嬬缉瀹屾垚锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	} else {
		echo '鏁版嵁搴撳鍑哄苟鍘嬬缉澶辫触锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	}
	exit;
//鑾峰彇琛ㄧ殑鍚嶇О
	mainbottom();
}

function list_tables($database) {
	$rs = mysqli_list_tables($database);
	$tables = array();
	while ($row = mysqli_fetch_row($rs)) {
		$tables[] = $row[0];
	}
	mysqli_free_result($rs);
	return $tables;
}
//瀵煎嚭鏁版嵁搴?
function dump_table($table, $fp = null) {
	$need_close = false;
	if (is_null($fp)) {
		$fp = fopen($table . '.sql', 'w');
		$need_close = true;
	}
	$a = mysqli_query($conn, "show create table `{$table}`");
	$row = mysqli_fetch_assoc($a);
	fwrite($fp, $row['Create Table'] . ';'); //瀵煎嚭琛ㄧ粨鏋?
	$rs = mysqli_query($conn, "SELECT * FROM `{$table}`");
	while ($row = mysqli_fetch_row($rs)) {
		fwrite($fp, get_insert_sql($table, $row));
	}
	mysqli_free_result($rs);
	if ($need_close) {
		fclose($fp);
	}
}
//瀵煎嚭琛ㄦ暟鎹?
function get_insert_sql($table, $row) {
	$sql = "INSERT INTO `{$table}` VALUES (";
	$values = array();
	foreach ($row as $value) {
		$values[] = "'" . mysqli_real_escape_string($value) . "'";
	}
	$sql .= implode(', ', $values) . ");";
	return $sql;
}

function z($dename) {
	global $dename;
	maintop("鐩綍鍘嬬缉");
	echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n"
		. "<font class=error>**璀﹀憡: 杩欏皢杩涜鐩綍鍘嬬缉涓? . $dename . ".zip鐨勫姩浣? 濡傚瓨鍦ㄨ鏂囦欢锛岃鏂囦欢灏嗚瑕嗙洊!**</font><br><br>\n"
		. "纭畾瑕佽繘琛岀洰褰曞帇缂?<br><br>\n"
		. "<a href=\"" . $adminfile . "?op=zip&dename=" . $dename . "&folder=$folder\">纭畾</a> | \n"
		. "<a href=\"" . $adminfile . "?op=home\"> 鍙栨秷 </a>\n"
		. "</table>\n";
	mainbottom();
}

function zip($dename) {
	global $dename;
	$path = './' . $dename;
	maintop("鐩綍鍘嬬缉");
	if (file_exists($dename . '.zip')) {
		unlink($dename . '.zip');} else {
	}
	class Zipper extends ZipArchive {
		public function addDir($path) {
			print 'adding ' . $path . '<br>';
			$this->addEmptyDir($path);
			$nodes = glob($path . '/*');
			foreach ($nodes as $node) {
				print $node . '<br>';
				if (is_dir($node)) {
					$this->addDir($node);
				} else if (is_file($node)) {
					$this->addFile($node);
				}
			}
		}
	}
	$zip = new Zipper;
	$res = $zip->open($dename . '.zip', ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addDir($path);
		$zip->close();
		echo '鍘嬬缉瀹屾垚锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	} else {
		echo '鍘嬬缉澶辫触锛?
			. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	}
	mainbottom();
}

function killme($dename) {
	global $folder;
	if (!$dename == "") {
		maintop("鑷潃");
		if (unlink($folder . $dename)) {
			echo "鑷潃鎴愬姛. "
				. "&nbsp;<a href=" . $folder . ">杩斿洖缃戠珯棣栭〉</a>\n";
		} else {
			echo "鏃犳硶鑷潃. "
				. "&nbsp;<a href=\"/\">杩斿洖缃戠珯棣栭〉</a>\n";
		}
		mainbottom();
	} else {
		home();
	}
}

/****************************************************************/
/* function ftpa()                                              */
/*                                                              */
/* First step to backup sql.                                    */
/****************************************************************/

function ftpa() {
	maintop("FTP鍔熻兘");
	echo $content
		. "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\"></table><font class=error>**璀﹀憡: 杩欏皢鎶婃枃浠惰繙绋嬩笂浼犲埌鍏朵粬ftp! 濡傜洰褰曞瓨鍦ㄨ鏂囦欢,鏂囦欢灏嗚瑕嗙洊!**</font><br><br><form action=\"" . $adminfile . "?op=ftpall\" method=\"POST\">FTP&nbsp;鍦板潃:&nbsp;&nbsp;<input name=\"ftpip\" size=\"30\" /><br>FTP&nbsp;鐢ㄦ埛:&nbsp;&nbsp;<input name=\"ftpuser\" size=\"30\" /><br>FTP&nbsp;瀵嗙爜:&nbsp;&nbsp;<input name=\"ftppass\" size=\"30\" /><br>涓婁紶鏂囦欢:&nbsp;&nbsp;<input name=\"ftpfile\" size=\"30\" /><br><input name=\"submit\" value=\"澶囦唤\" type=\"submit\" /></form>\n
";
	mainbottom();
}

/****************************************************************/
/* function ftpall()                                         */
/*                                                              */
/* Second step in backup sql.                                   */
/****************************************************************/
function ftpall($ftpip, $ftpuser, $ftppass, $ftpfile) {
	maintop("FTP鍔熻兘");
	$ftp_server = $ftpip; //鏈嶅姟鍣?
	$ftp_user_name = $ftpuser; //鐢ㄦ埛鍚?
	$ftp_user_pass = $ftppass; //瀵嗙爜
	$ftp_port = '21'; //绔彛
	$ftp_put_dir = './'; //涓婁紶鐩綍
	$ffile = $ftpfile; //涓婁紶鏂囦欢

	$ftp_conn_id = ftp_connect($ftp_server, $ftp_port);
	$ftp_login_result = ftp_login($ftp_conn_id, $ftp_user_name, $ftp_user_pass);

	if ((!$ftp_conn_id) || (!$ftp_login_result)) {
		echo "杩炴帴鍒癴tp鏈嶅姟鍣ㄥけ璐?;
		exit;
	} else {
		ftp_pasv($ftp_conn_id, true); //杩斿洖涓€涓嬫ā寮忥紝杩欏彞寰堝鎬紝鏈変簺ftp鏈嶅姟鍣ㄤ竴瀹氶渶瑕佹墽琛岃繖鍙?
		ftp_chdir($ftp_conn_id, $ftp_put_dir);
		$ftp_upload = ftp_put($ftp_conn_id, $ffile, $ffile, FTP_BINARY);
		//var_dump($ftp_upload);//鐪嬬湅鏄惁鍐欏叆鎴愬姛
		ftp_close($ftp_conn_id); //鏂紑
	}
	echo "鏂囦欢 " . $ftpfile . " 涓婁紶鎴愬姛.\n"
		. "&nbsp;<a href=\"" . $adminfile . "?op=home\">杩斿洖鏂囦欢绠＄悊</a>\n";
	mainbottom();
}

/****************************************************************/
/* function printerror()                                        */
/*                                                              */
/* Prints error onto screen                                     */
/* Recieves $error and prints it.                               */
/****************************************************************/
function printerror($error) {
	maintop("閿欒");
	echo "<font class=error>\n" . $error . "\n</font>";
	mainbottom();
}

/****************************************************************/
/* function switch()                                            */
/*                                                              */
/* Switches functions.                                          */
/* Recieves $op() and switches to it                            *.
/****************************************************************/
switch ($op) {

case "home":
	home();
	break;
case "up":
	up();
	break;
case "yupload":
	yupload($_POST['url']);
	break;
case "upload":
	upload($_FILES['upfile'], $_REQUEST['ndir']);
	break;

case "del":
	del($_REQUEST['dename']);
	break;

case "delete":
	delete($_REQUEST['dename']);
	break;

case "unz":
	unz($_REQUEST['dename']);
	break;

case "unzip":
	unzip($_REQUEST['dename']);
	break;

case "sqlb":
	sqlb();
	break;

case "sqlbackup":
	sqlbackup($_POST['ip'], $_POST['sql'], $_POST['username'], $_POST['password']);
	break;

case "ftpa":
	ftpa();
	break;

case "ftpall":
	ftpall($_POST['ftpip'], $_POST['ftpuser'], $_POST['ftppass'], $_POST['ftpfile']);
	break;

case "allz":
	allz();
	break;

case "allzip":
	allzip();
	break;

case "edit":
	edit($_REQUEST['fename']);
	break;

case "save":
	save($_REQUEST['ncontent'], $_REQUEST['fename']);
	break;

case "cr":
	cr();
	break;

case "create":
	create($_REQUEST['nfname'], $_REQUEST['isfolder'], $_REQUEST['ndir']);
	break;

case "chm":
	chm($_REQUEST['file']);
	break;

case "chmodok":
	chmodok($_REQUEST['rename'], $_REQUEST['nchmod'], $folder);
	break;

case "ren":
	ren($_REQUEST['file']);
	break;

case "rename":
	renam($_REQUEST['rename'], $_REQUEST['nrename'], $folder);
	break;

case "mov":
	mov($_REQUEST['file']);
	break;

case "move":
	move($_REQUEST['file'], $_REQUEST['ndir'], $folder);
	break;

case "viewframe":
	viewframe($_REQUEST['file']);
	break;

case "viewtop":
	viewtop($_REQUEST['file']);
	break;

case "printerror":
	printerror($error);
	break;

case "logout":
	logout();
	break;

case "z":
	z($_REQUEST['dename']);
	break;

case "zip":
	zip($_REQUEST['dename']);
	break;

case "killme":
	killme($_REQUEST['dename']);
	break;

default:
	home();
	break;
}
?>
