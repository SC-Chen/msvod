//#################################################
var BASE_URL = "";
var chunkSize = 10 * 1024 * 1024; //�ֿ��С
var userInfo = {
userId: "the_user",
md5: "",
uniqueFileName: ""
}; //�û��Ự��Ϣ

var _cache = {};
//#################################################
var uniqueFileName = null; //�ļ�Ψһ��ʶ��
var md5Mark = null;
var uploader;
jQuery(function() {
//#############################################
WebUploader.Uploader.register({
"before-send-file": "beforeSendFile",
"before-send": "beforeSend",
"after-send-file": "afterSendFile"
},
{
beforeSendFile: function(file) {
var task = new $.Deferred();
var start = new Date().getTime();
$("#" + file.id).attr("data-time", new Date().getTime());
(new WebUploader.Uploader()).md5File(file, 0, 10 * 1024 * 1024).progress(function(percentage) {				
console.log(percentage);
}).then(function(val) {
console.log("�ܺ�ʱ: " + ((new Date().getTime()) - start) / 1000);
md5Mark = val;
userInfo.md5 = val;
$.ajax({
type: "POST",
url: ServerUrl,
data: {
status: "md5Check",
md5: val,
name : file.name.replace("." + file.ext, "")
},
cache: false,
timeout: 1000,
//todo ��ʱ�Ļ���ֻ����Ϊ���ļ������ϴ���
dataType: "json"
}).then(function(data, textStatus, jqXHR) {
if (data.ifExist) { //�����ڣ��ⷵ��ʧ�ܸ�WebUploader���������ļ�����Ҫ�ϴ�
//task.reject();
$(".progressBarInProgress").css("width", "100%");
$(".percent_str").html("�봫�ɹ�");
//alert(JSON.stringify(data));
$("#name").val(data.title);
$("#sc").val(data.duration);
$("#pic").val(data.pic);
$("#purl").val(data.url);
$("#durl").val(data.mp4);
var id = data.share.substring(data.share.lastIndexOf("/") + 1, data.share.length);
$("#videoid").val(id);

task.resolve();
uploader.skipFile(file);
} else {
task.resolve();
//�õ��ϴ��ļ���Ψһ���ƣ����ڶϵ�����
uniqueFileName = md5('' + userInfo.userId + file.name + file.type + file.lastModifiedDate + file.size);
_cache[file.name] = uniqueFileName;

userInfo.uniqueFileName = uniqueFileName;
}
},
function(jqXHR, textStatus, errorThrown) { //�κ���ʽ����֤ʧ�ܣ������������ϴ�
task.resolve();
//�õ��ϴ��ļ���Ψһ���ƣ����ڶϵ�����
uniqueFileName = md5('' + userInfo.userId + file.name + file.type + file.lastModifiedDate + file.size);
userInfo.uniqueFileName = uniqueFileName;
});
});
return $.when(task);
},
beforeSend: function(block) {
//��Ƭ��֤�Ƿ��Ѵ��������ڶϵ�����

var task = new $.Deferred();
$.ajax({
type: "POST",
url: ServerUrl,
data: {
status: "chunkCheck",
name: uniqueFileName,
chunkIndex: block.chunk,
size: block.end - block.start
},
cache: false,
timeout: 1000,
//todo ��ʱ�Ļ���ֻ����Ϊ�÷�Ƭδ�ϴ���
dataType: "json"
}).then(function(data, textStatus, jqXHR) {
if (data.ifExist) { //�����ڣ�����ʧ�ܸ�WebUploader�������÷ֿ鲻��Ҫ�ϴ�
task.reject();
} else {
task.resolve();
}
},
function(jqXHR, textStatus, errorThrown) { //�κ���ʽ����֤ʧ�ܣ������������ϴ�
task.resolve();
});
return $.when(task);
},
afterSendFile: function(file) {
var chunksTotal = 0;
//alert(_cache[file.name] );
//alert( uniqueFileName)
chunksTotal = Math.ceil(file.size / chunkSize)
//console.log("chunksTotal : " + chunksTotal);
if ( chunksTotal >= 1) {
//�ϲ�����
var task = new $.Deferred();
$.ajax({
type: "POST",
url: ServerUrl,
data: {
status: "chunksMerge",
name: uniqueFileName,
chunks: chunksTotal,
ext: file.ext,
fileoldname: file.name.replace("." + file.ext, ""),
md5: md5Mark
},
cache: false,
dataType: "json"
}).then(function(data, textStatus, jqXHR) {
//todo �����Ӧ�Ƿ�����
task.resolve();
file.path = data.path;
UploadComlate(file);
var file_old_name = $.trim($("#" + file.id).find(".progressName").text());
if(data.title){
$("#name").val(data.title);
$("#pic").val(data.pic);
$("#purl").val(data.url);
$("#durl").val(data.mp4);					
var id = data.share.substring(data.share.lastIndexOf("/") + 1, data.share.length);
$("#videoid").val(id);
$("#sc").val(data.duration);
}
$("#moviesay").val(file.name.replace("." + file.ext, ""));
},
function(jqXHR, textStatus, errorThrown) {
task.reject();
});
return $.when(task);
} else {
UploadComlate(file);
}
}
});
//#############################################
var $ = jQuery,
$list = $('#divFileProgressContainer'),
state = 'pending';
//alert(ServerUrl);
uploader = WebUploader.create({
dnd: "#chosevideo",
paste: document.body,
auto: true,
resize: false,
// ��ѹ��image
swf: BASE_URL + '/e/extend/upload/js/Uploader.swf',
// swf�ļ�·��
server: ServerUrl,
// �ļ����շ���ˡ�
pick: {
id: '#chosevideo',
},
accept: {
title: 'Files',
extensions: 'rmvb,flv,vob,mp4,mov,3gp,wmv,mp3,mkv,mpg,ts,avi,mpeg,avi,rm,wav,asf,divx,mpg,mpe,vod',
mimeTypes: '.rmvb,.flv,.vob,.mp4,.mov,.3gp,.wmv,.mp3,.mkv,.mpg,.ts,.avi,.mpeg,.avi,.rm,.wav,.asf,.divx,.mpg,.mpe,.vod'
},
duplicate: false,
chunked: true,
chunkSize: chunkSize,
threads : 1,
multiple : false, //���ļ�ѡ��
formData: function() {
return $.extend(true, {},
userInfo);
}
});
// �����ļ����ӽ�����ʱ��
uploader.on('fileQueued',
function(file) {
console.log("���ļ����ӽ�����" + file.name + "," + file.id + file.size);
var file_size_M = roundNumber(((file.size / 1024) / 1024), 1);
var html = "";
html += "<div style=\"height:100px;\" id=\"" + file.id + "\" data-size=\"" + file.size + "\" data-time=\"" + new Date().getTime() + "\">";
html += "    <div class=\"progressWrapper\" id=\"divFileProgress\" style=\"opacity: 1;\">";
html += "        <div class=\"progressContainer green\">";
html += "            <div class='jindu'><div class=\"progressBarInProgress\" style=\"width: 0.01%;\"></div></div>";
html += "            <div class=\"progressBarStatus\"><ul>";
html += "                <li class='first'><b><font color=\"red\" class=\"uploaded_size\"></font></b>MB/" + file_size_M + "MB</li>";
html += "                <li>�ϴ��ٶ�:<b><font color=\"red\" class=\"uploaded_speed\">0</font></b>KB/��</li>";
html += "                <li><span class=\"time_name\">ʣ��ʱ��</span>:<b><font color=\"red\" class=\"time_left\"></font></b></li>";
html += "                <li class='last'><span class=\"percent_str\">�ܽ���:<b><font color=\"red\" class=\"percent_num\"></font></b></span></li>";
html += "            </ul></div>";
html += "        </div>";
html += "    </div>";
html += "</div>";
$list.append(html);
});
// �ļ��ϴ������д���������ʵʱ��ʾ��
uploader.on('uploadProgress',
function(file, percentage) {
console.log("�ļ��ϴ����ȣ�" + file.id + "," + percentage);
var $li = $('#' + file.id);
//$li.find('p.state').text('�ϴ���');
$li.find('.progressBarInProgress').css('width', percentage * 100 + '%');
$li.find('.percent_num').html((percentage * 100).toFixed(2) + '%');
var total_size = parseFloat($li.attr("data-size"));
var uploaded_size = total_size * percentage;
var uploaded_size_show = roundNumber(((uploaded_size / 1024) / 1024), 1).toFixed(1);
$li.find('.uploaded_size').html(uploaded_size_show);
var currentTime = new Date().getTime();
var start_time = parseInt($li.attr("data-time"));
var used_time = (Math.ceil(currentTime - start_time) / 1000);
var uploaded_speed = Math.floor(roundNumber(((uploaded_size / used_time) / 1024), 2));
$li.find('.uploaded_speed').html(uploaded_speed);
var tempTime = roundNumber(((((total_size - uploaded_size) / uploaded_speed) / 60) / 10), 2);
var time_left = "";
if (tempTime != "Infinity") {
if (tempTime > 0) {
time_left = minsec("m", tempTime) + "��:" + minsec("s", tempTime) + '��';
} else {
time_left = "��ȴ�...";
}
} else {
time_left = "��ȴ�...";
}
$li.find('.time_left').html(time_left);
});
//�ļ��ϴ�����
uploader.on('uploadError',
function(file) {
console.log("Error��" + file.id);
if (state != 'stoped' && state != 'finished') {
//jError("�ϴ����󣬿���������ԭ�����Ժ�����",{HorizontalPosition : 'center',VerticalPosition:'center'});
alert(file.name + " �ϴ����󣬿���������ԭ�����Ժ�����");
}
});
//�ļ��ϴ��ɹ�
uploader.on('uploadSuccess',
function(file) {
console.log("Done��" + file.id);
var $li = $('#' + file.id);
var currentTime = new Date().getTime();
var start_time = parseInt($li.attr("data-time"));
var used_time = (Math.ceil(currentTime - start_time) / 1000);
var used_time_str = minsec("m", used_time) + "��:" + minsec("s", used_time) + '��';
$li.find('.time_name').html("����ʱ");
$li.find('.time_left').html(used_time_str);
$li.find('.percent_str').html("�ϴ���ɣ����ύ");
$li.find('.cancle').hide();
});
uploader.on('uploadComplete',
function(file) {
console.log("Complete��" + file.id);
});
uploader.on('all',function(type) {
console.log(type);
if (type === 'startUpload') {
state = 'started';
console.log("��ʼ�ϴ���~");
} else if (type === 'stopUpload') {
state = 'stoped';
console.log("��ʼ��ͣ��~");
} else if (type === 'uploadFinished') {
state = 'finished';
console.log("��ʼ������~");
}
});
});
function UploadComlate(file) {
console.log("done###" + file.id);
}
function roundNumber(num, dec) {
var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
return result;
}
function minsec(time, tempTime) {
var ztime;
if (time == "m") {
ztime = Math.floor(tempTime / 60);
if (ztime < 10) {
ztime = "0" + ztime;
}
} else if (time == "s") {
ztime = Math.ceil(tempTime % 60);
if (ztime < 10) {
ztime = "0" + ztime;
}
} else {
ztime = "minsec error...";
}
return ztime;
}
function upload_cancle(id) {
uploader.stop(id);
$("#" + id).remove();
}