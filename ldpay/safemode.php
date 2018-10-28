<?php
foreach ($_GET as $get_key=>$get_var) 
{ 
if (is_numeric($get_var)) { 
$get[strtolower($get_key)] = get_int($get_var); 
} else { 
$get[strtolower($get_key)] = get_str($get_var); 
} 
} 
foreach ($_POST as $post_key=>$post_var) 
{ 
if (is_numeric($post_var)) { 
$post[strtolower($post_key)] = get_int($post_var); 
} else { 
$post[strtolower($post_key)] = get_str($post_var); 
} 
} 
function get_int($number) 
{ 
return intval($number); 
} 
function get_str($string) 
{ 
if (!get_magic_quotes_gpc()) { 
return addslashes($string); 
} 
return $string; 
}
class safeMode{
public function xss($group = 1,$projectName = NULL){
$referer = empty ( $_SERVER ['HTTP_REFERER'] ) ? array () : array ($_SERVER ['HTTP_REFERER'] );
$getfilter = "'|<[^>]*?>|^\\+\/v(8|9)|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter = "^\\+\/v(8|9)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|<\\s*img\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
foreach ( $_GET as $key => $value ) {
$this->stopAttack ( $key, $value, $getfilter ,$group , $projectName);
}
foreach ( $_POST as $key => $value ) {
$this->stopAttack ( $key, $value, $postfilter ,$group , $projectName);
}
foreach ( $_COOKIE as $key => $value ) {
$this->stopAttack ( $key, $value, $cookiefilter ,$group , $projectName);
}
foreach ( $referer as $key => $value ) {
$this->stopAttack ( $key, $value, $getfilter ,$group , $projectName);
}
}
public function stopAttack($strFiltKey, $strFiltValue, $arrFiltReq,$group = 1,$projectName = NULL) {
$strFiltValue = $this->arr_foreach ( $strFiltValue );
if (preg_match ( "/" . $arrFiltReq . "/is", $strFiltValue ) == 1) {
$ip = "操作IP: ".$_SERVER["REMOTE_ADDR"];
$time = " 操作时间: ".strftime("%Y-%m-%d %H:%M:%S");
$thePage = " 操作页面: ".$this->request_uri();
$type = " 提交方式: ".$_SERVER["REQUEST_METHOD"];
$key = " 提交参数: ".$strFiltKey;
$value = " 提交数据: ".htmlspecialchars($strFiltValue);
$strWord = $ip.$time.$thePage.$type.$key.$value;
if($group == 1){
$this->log_result_common($strWord,$projectName);
}
if($group == 2){
$strWord .= "<br>";
$this->slog($strWord,$projectName);
}
if($group == 3){
$this->sDb($strWord);   
}
$_REQUEST[$strFiltKey] = '';
}
if (preg_match ( "/" . $arrFiltReq . "/is", $strFiltKey ) == 1) {
$ip = "操作IP: ".$_SERVER["REMOTE_ADDR"];
$time = " 操作时间: ".strftime("%Y-%m-%d %H:%M:%S");
$thePage = " 操作页面: ".$this->request_uri();
$type = " 提交方式: ".$_SERVER["REQUEST_METHOD"];
$key = " 提交参数: ".$strFiltKey;
$value = " 提交数据: ".htmlspecialchars($strFiltValue);
$strWord = $ip.$time.$thePage.$type.$key.$value;
if($group == 1){
$this->log_result_common($strWord,$projectName);
}
if($group == 2){
$strWord .= "<br>";
$this->slog($strWord,$projectName);
}
if($group == 3){
$this->sDb($strWord);   
}
$_REQUEST[$strFiltKey] = '';
}
}
public function request_uri() {
if (isset ( $_SERVER ['REQUEST_URI'] )) {
$uri = $_SERVER ['REQUEST_URI'];
} else {
if (isset ( $_SERVER ['argv'] )) {
$uri = $_SERVER ['PHP_SELF'] . '?' . $_SERVER ['argv'] [0];
} else {
$uri = $_SERVER ['PHP_SELF'] . '?' . $_SERVER ['QUERY_STRING'];
}
}
return $uri;
}
public function log_result_common($strWord, $strPathName = NULL) {
if($strPathName == NULL){
$strPath = "/var/tmp/";
$strDay = date('Y-m-d');
$strPathName = $strPath."common_log_".$strDay.'.log';
}
$fp = fopen($strPathName,"a");
flock($fp, LOCK_EX) ;
fwrite($fp,$strWord." date ".date('Y-m-d H:i:s',time())."\t\n");
flock($fp, LOCK_UN);
fclose($fp);
}
public function slog($strWord,$fileName = NULL) {
if($fileName == NULL){
$toppath = $_SERVER ["DOCUMENT_ROOT"] . "/log.htm";
}else{
$toppath = $_SERVER ["DOCUMENT_ROOT"] .'/'. $fileName;
}
$Ts = fopen ( $toppath, "a+" );
fputs ( $Ts, $strWord . "\r\n" );
fclose ( $Ts );
}
public function sDb($strWord){
}
public function arr_foreach($arr) {
static $str = '';
if (! is_array ( $arr )) {
return $arr;
}
foreach ( $arr as $key => $val ) {
if (is_array ( $val )) {
$this->arr_foreach ( $val );
} else {
$str [] = $val;
}
}
return implode ( $str );
}
}
?>
