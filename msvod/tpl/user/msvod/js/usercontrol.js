function AJAXRequest() {
	var xmlPool=new Array,AJAX=this,ac=arguments.length,av=arguments;
	var xmlVersion = ["MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
	var nullfun=function(){return;};
	var av=ac>0?typeof(av[0])=="object"?av[0]:{}:{};
	var encode=av.charset?av.charset.toUpperCase()=="UTF-8"?encodeURIComponent:escape:encodeURIComponent;
	this.url=av.url?av.url:"";
	this.oncomplete=av.oncomplete?av.oncomplete:nullfun;
	this.content=av.content?av.content:"";
	this.method=av.method?av.method:"POST";
	this.async=av.async?async:true;
	this.onexception=av.onexception?av.exception:nullfun;
	this.ontimeout=av.ontimeout?av.ontimeout:nullfun;
	this.timeout=av.timeout?av.timeout:3600000;
	if(!getObj()) return false;
	function getObj() {
		var i,tmpObj;
		for(i=0;i<xmlPool.length;i++) if(xmlPool[i].readyState==0||xmlPool[i].readyState==4) return xmlPool[i];
		try { tmpObj=new XMLHttpRequest; }
		catch(e) {
			for(i=0;i<xmlVersion.length;i++) {
				try { tmpObj=new ActiveXObject(xmlVersion[i]); } catch(e2) { continue; }
				break;
			}
		}
		if(!tmpObj) return false;
		else { xmlPool[xmlPool.length]=tmpObj; return xmlPool[xmlPool.length-1]; }
	}
	function $(id) { return document.getElementById(id); }
	function varobj(val) {
		if(typeof(val)=="string") {
			if(val=$(val)) return val;
			else return false;
		}
		else return val;
	}
	this.setcharset=function(cs) {
		if(cs.toUpperCase()=="UTF-8") encode=encodeURIComponent;
		else encode=escape;
	}
	this.send=function() {
		var purl,pc,pcbf,pm,pa,ct,ctf=false,xmlObj=getObj(),ac=arguments.length,av=arguments;
		if(!xmlObj) return false;
		purl=ac>0?av[0]:this.url;
		pc=ac>1?av[1]:this.content;
		pcbf=ac>2?av[2]:this.oncomplete;
		pm=ac>3?av[3].toUpperCase():this.method;
		pa=ac>4?av[4]:this.async;
		if(!pm||!purl||!pa) return false;
		var ev={url:purl, content:pc, method:pm};
		purl+=(purl.indexOf("?")>-1?"&":"?")+Math.random();
		xmlObj.open(pm,purl,pa);
		if(pm=="POST") xmlObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ct=setTimeout(function(){ctf=true;xmlObj.abort();},AJAX.timeout);
		xmlObj.onreadystatechange=function() {
			if(ctf) AJAX.ontimeout(ev);
			else if(xmlObj.readyState==4) {
				ev.status=xmlObj.status;
				try{ clearTimeout(ct); } catch(e) {};
				try{
					if(xmlObj.status==200) pcbf(xmlObj);
					else AJAX.onexception(ev);
				}
				catch(e) { AJAX.onexception(ev); }
			}
		}
		if(pm=="POST") xmlObj.send(pc); else xmlObj.send("");
	}
	this.get=function() {
		var purl,pcbf,ac=arguments.length,av=arguments;
		purl=ac>0?av[0]:this.url;
		pcbf=ac>1?av[1]:this.oncomplete;
		if(!purl&&!pcbf) return false;
		this.send(purl,"",pcbf,"GET",true);
	}
	this.update=function() {
		var purl,puo,pinv,pcnt,rinv,ucb,ac=arguments.length,av=arguments;
		puo=ac>0?av[0]:null;
		purl=ac>1?av[1]:this.url;
		pinv=ac>2?(isNaN(parseInt(av[2]))?1000:parseInt(av[2])):null;
		pcnt=ac>3?(isNaN(parseInt(av[3]))?null:parseInt(av[3])):null;
		if(puo=varobj(puo)) {
			ucb=function(obj) {
				var nn=puo.nodeName.toUpperCase();
				if(nn=="INPUT"||nn=="TEXTAREA") puo.value=obj.responseText;
				else try{puo.innerHTML=obj.responseText;} catch(e){};
			}
		}
		else ucb=nullfun;
		if(pinv) {
			AJAX.send(purl,"",ucb,"GET",true);
			if(pcnt&&--pcnt) {
				var cf=function(cc) {
					AJAX.send(purl,"",ucb,"GET",true);
					if(cc<1) return; else cc--;
					setTimeout(function(){cf(cc);},pinv);
				}
				setTimeout(function(){cf(--pcnt);},pinv);
			}
			else return(setInterval(function(){AJAX.send(purl,"",ucb,"GET",true);},pinv));
		}
		else this.send(purl,"",ucb,"GET",true);
	}
	this.post=function() {
		var purl,pcbf,pc,ac=arguments.length,av=arguments;
		purl=ac>0?av[0]:this.url;
		pc=ac>1?av[1]:"";
		pcbf=ac>2?av[2]:this.oncomplete;
		if(!purl&&!pcbf) return false;
		this.send(purl,pc,pcbf,"POST",true);
	}
	this.postf=function() {
		var fo,pcbf,purl,pc,pm,ac=arguments.length,av=arguments;
		if(!(fo=ac>0?av[0]:null)) return false;
		if(fo=varobj(fo)) {
			if(fo.nodeName!="FORM") return false;
		}
		else return false;
		pcbf=ac>1?av[1]:this.oncomplete;
		purl=ac>2?av[2]:(fo.action?fo.action:this.url);
		pm=ac>3?av[3]:(fo.method?fo.method.toUpperCase():"POST");
		if(!pcbf&&!purl) return false;
		pc=this.formToStr(fo);
		if(!pc) return false;
		if(pm) {
			if(pm=="POST") this.send(purl,pc,pcbf,"POST",true);
			else if(purl.indexOf("?")>0) this.send(purl+"&"+pc,"",pcbf,"GET",true);
				else this.send(purl+"?"+pc,"",pcbf,"GET",true);
		}
		else this.send(purl,pc,pcbf,"POST",true);
	}
 
	this.formToStr=function(fc) {
		var i,qs="",and="",ev="";
		for(i=0;i<fc.length;i++) {
			e=fc[i];
			if (e.name!='') {
				if (e.type=='select-one'&&e.selectedIndex>-1) ev=e.options[e.selectedIndex].value;
				else if (e.type=='checkbox' || e.type=='radio') {
					if (e.checked==false) continue;
					ev=e.value;
				}
				else ev=e.value;
				ev=encode(ev);
				qs+=and+e.name+'='+ev;
				and="&";
			}
		}
		return qs;
	}
}

function SetInHeight(){
	var num=0
	var lh=document.documentElement.clientHeight;
	var sorlh=$(document).scrollTop();
	lh=lh+sorlh-num;
	if (lh<620){lh=620}
	$(".sidebar").attr("style","height:"+lh+"px");		
}
function Alert(curct,num){
	var cts;
	if (num==0){cts="<img src='/user/images/err.gif' style='width:43px;'>";curct='<span class="tserr">'+curct+"</span>"}
	else{cts="<img src='/user/images/suc.gif' style='width:43px;'>";curct='<span  class="tssuc">'+curct+"</span>"}
	art.dialog({
	id:"showmsg1",
	title:"消息提示",
    time: 2,
	lock:true,
    content: cts+"&nbsp;"+curct
	});
}

function AlertRe(curct,num){
	var cts;
	if (num==0){cts="<img src='/user/images/err.gif' style='width:43px;'>";curct='<span class="tserr">'+curct+"</span>"}
	else{cts="<img src='/user/images/suc.gif' style='width:43px;'>";curct='<span  class="tssuc">'+curct+"</span>"}
 	art.dialog({
	id:"showmsg1",
	title:"消息提示",
    time: 2,
	lock:true,
    content: cts+"&nbsp;"+curct
	});
	setTimeout("location.reload()",3000);
}

function AlertUrl(curct,num,cururl){
	var cts;
	if (num==0){cts="<img src='/user/images/err.gif' style='width:43px;'>";curct='<span class="tserr">'+curct+"</span>"}
	else{cts="<img src='/user/images/suc.gif' style='width:43px;'>";curct='<span class="tssuc">'+curct+"</span>"}
 	art.dialog({
	id:"showmsg1",
	title:"消息提示",
    time: 2,
	lock:true,
    content: cts+"&nbsp;"+curct
	});
	if (cururl!=""){
		setTimeout(location.href=cururl,3000);
	}
}


$(document).ready(function(){
 	SetInHeight();setInterval("SetInHeight()",5)				   
});


function FunFouces(act,lx){
	 if (act=="clear"){
	 	if (confirm("确定清空关注吗？")){
			$.get("fouces.asp?action="+act+"&lx="+lx, function(data){
				 if (data=="true"){location.reload()}
				 else{alert('清空关注失败!')}
			});
		}
	 }else{
		var selid="";
		$(".sel").each(function(){
			if ($(this).attr("checked")){
				(selid=="")? selid=$(this).val() : selid+=","+$(this).val();
			}
		});
		if (selid==""){
			alert('请先选择要取消关注的记录!')
		}else{
			$.get("fouces.asp?action="+act+"&lx="+lx+"&selid="+selid, function(data){
				 if (data=="true"){location.reload()}
				 else{alert('取消关注失败!')}
			});
		}
	 }
}
function Login(){
 		var lerr=$("#loginerr").val();
		if (lerr=="0"){
			$("#codehtml").show();
			$("#imgcode").click(function(){GetCode()});
			GetCode();
		}
		$(".dlhover").hover(function() {$(this).attr("class","dlhover btdl2")},function(){$(this).attr("class","dlhover btdl")})
		$(document).ready(function(){ 
		$(document).keydown(function(e){ 
		var curKey = e.which; 
		if(curKey == 13){ 
		    $("#dologin").click();} 
		}); 
		}); 
}
function SetCookie(a, b) {
    var c = 5,
    d = new Date;
    d.setTime(d.getTime() + 1e3 * 60 * 60 * 24 * c),
    document.cookie = a + "=" + escape(b) + ";expires=" + d.toGMTString() + ";path=/;"
}
function GetCookie(a) {
    var b = document.cookie.match(new RegExp("(^| )" + a + "=([^;]*)(;|$)"));
    return null != b ? unescape(b[2]) : ""
}
function DelCookie(a) {
    var c,
    b = new Date;
    b.setTime(b.getTime() - 1),
    c = GetCookie(a),
    null != c && (document.cookie = a + "=" + c + ";expires=" + b.toGMTString() + ";path=/;")
}
function GetCode(){
	 $("#imgcode").attr("src","/inc/checksimg.asp?t="+new Date().getTime()) 	
}
function LoginIn(){
  var obju=$("#username");
  var objp=$("#password");
  var objc=$("#code");
  var obje=$("#errinfo");
  var lerr=$("#loginerr").val();
  if(obju.val().length>12 || obju.val().length<2){
 	obje.attr("className","loginerr");
	obje.html("用户名不正确...");
	return false;
  }
  if(objp.val().length>20 || objp.val().length<6){
 	obje.attr("className","loginerr");
	obje.html("密码不正确");
	return false;
  }
  if (lerr==0){
	  if(objc.val().length!=5){
 		obje.attr("className","loginerr");
		obje.html("验证码不正确");
		return false;
	  }
  }
  $('#lan1').hide();$('#lan2').show();
  $("#regframe").html("<iframe width='100%' height='0' name='regtj' id='regtj' src='404.html'></iframe>")
  return true;
}
function winopen(curstr,curnum){
		var tempwindow=window.open('/user/openlogin.html');
		var ajax=new AJAXRequest;ajax.get("/loginapi/otherlogin.asp?action="+curstr+"&openstyle="+curnum,function(obj){
		tempwindow.location=obj.responseText;})
}
function download(id){
	art.dialog.open('/download.asp?id='+id, {title: '下载舞曲',lock:true,background:"#666666",width:445, height:500,opacity:0.5,padding:"50px 50px"});
}


function PutCar(a, b) {
    "" != a && (1 == b ? (tmpcsid = GetCookie("csid"), "" != tmpcsid ? tmpcsid += a + "," :tmpcsid = a + ",", 
    SetCookie("csid", tmpcsid), AlertS(a, 1)) :(tmpdqid = GetCookie("dqid"), "" != tmpdqid ? tmpdqid += a + "," :tmpdqid = a + ",", 
    SetCookie("dqid", tmpdqid), AlertS(a, 1)));
}

function AlertS(a, b) {
    var c, d, e, f = 0, g = 0, h = 0, i = GetCookie("csid"), j = GetCookie("dqid");
    switch ("" != i && (arcsid = i.split(","), f = arcsid.length - 1), "" != j && (ardqid = j.split(","), 
    g = ardqid.length - 1, h = g % 12 > 0 ? parseInt(g / 12) + 1 :parseInt(g / 12)), 
    c = f + h, b) {
      case 0:
        $("#carcontent").html("舞曲“<span>" + a + "</span>”您之前已经添加过了...<br>您的CD购物车共有“<span>" + c + "</span>”张CD!");
        break;

      case 1:
        $("#carcontent").html("舞曲“<span>" + a + "</span>”已成功加入CD购物车...<br>您的CD购物车共有“<span>" + c + "</span>”张CD!");
    }
    $("#overlay1").fadeTo(200, .5);
	document.getElementById("carshow").style.marginTop =-50%
    $("#carshow").show();ShowCdQuantity();
}
function Hidecar() {
    $("#overlay1").fadeOut(200), $("#carshow").hide();
}
function HideScbox() {
    $("#overlay1").fadeOut(200), $("#scshow").hide();
}

function ShowScbox(){
	$("#overlay1").fadeTo(200, .5);
	$("#scshow").show();
}

document.writeln('<div id="overlay1" style="display:none"></div>'), document.writeln('<div id="carshow" style="display:none">'), 
document.writeln('   <div class="cdcart"><p class="k1">&nbsp;&nbsp;CD刻录</p>'), 
document.writeln('   <p class="k2"><a href="javascript:void(0)" id="cdcls" onClick="Hidecar()"/><a></p></div> '), 
document.writeln("<ul> "), document.writeln(' <table width="100%" border="0" cellpadding="0" cellspacing="0">'), 
document.writeln("  <tr>"), document.writeln('    <td width="25%" height="80" align="center" id="carimg"><img src="/car/images/carsuccess.gif" width="58" height="59"></td>'), 
document.writeln('    <td width="75%" id="carcontent">&nbsp; </td>'), document.writeln("  </tr>"), 
document.writeln("  <tr>"), document.writeln('    <td height="40" colspan="2" align="center" id="carimg3"><input name="button" type="button" class="btn btn-small btn-default" id="button" value="继续选歌"onClick="Hidecar()"> &nbsp;&nbsp;&nbsp;<input name="button2" type="button" class="btn btn-small btn-primary" id="button2" value="查看CD刻录" onClick="location.href=\'/car/\'"></td>'), 
document.writeln("    </tr>"), document.writeln("</table>"), document.writeln("</ul>"), 
document.writeln("</div>");

document.writeln('<div id="scshow" style="display:none">')
document.writeln('<div class="sctitle" ><p class="k1">&nbsp;&nbsp;音乐盒舞曲转移</p>')
document.writeln('<p class="k2"><a href="javascript:void(0)" onClick="HideScbox()"></a></p></div>')
document.writeln('<ul><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>') 
document.writeln('<td id="sccontent">&nbsp;</td>') 
document.writeln('</tr></table></ul></div>')


var cstitle, dqtitle;

function GetCdcount() {
    var h, a;
    h = GetCookie("csid");
    a = GetCookie("dqid");
    $("#carlist_cs").html("");
    l = 0;
    c = 0;
    if (h != "") {
        arcsid = h.split(",");
        l = arcsid.length - 1;
    }
    if (a != "") {
        ardqid = a.split(",");
        k = ardqid.length - 1;
        var d = 0;
        var b = 0;
        c = k % 12 > 0 ? parseInt(k / 12) + 1 :parseInt(k / 12);
    }
    var tcount = 0;
    tcount = l + c;
    return tcount;
}
function trim(s){
	return s.replace(/(^s*)|(s*$)/g, "");
}
function ShowCdQuantity() {
    var tmpc = GetCdcount();
    if (tmpc > 0) {
        $("#cdquantity").html(tmpc);
        $("#cdquantity").show();
    } else {
        $("#cdquantity").hide();
    }
}
document.writeln("<div id=\"overlay\" style=\"display:none\"></div><div id=\"favbox\" style=\"display:none\"></div>");
var FAV={
	IsHide:0,
	SetIsHide:function(auid){this.IsHide=auid},
	Boxid:0,Musicid:0,
	SetBoxid:function(curid,curname){this.Boxid=curid;$("#selid").html(curname);
 		$("#selboxct ul").each(function(){
  			 if(this.id=="box"+curid){this.className="selboxctcls"}
			 else{this.className=""}
		});
	
	},
	SetMusicid:function(curyid){this.Musicid=curyid},
	SelFav:function(id){
		FAV.SetIsHide(1);
		var ajax = new AJAXRequest();
		ajax.async = true;
		ajax.timeout = 5e3;
		ajax.ontimeout = timeo;
		ajax.oncomplete = callback;
		ajax.get("/user/fav.asp?action=selbox&musicid="+id);
		function callback(obj) {
			var re =trim(obj.responseText);
			eval("var reobj="+re);
			switch (reobj.Result) {
			   case 101:
			   		
					break;
			   case 200:
			   		FAV.SetMusicid(id);
					var selhtml="<div class='seltitle'><ul>舞曲收藏</ul><p class='selclo' ><a href='javascript:void(0)' onclick='FAV.Hide()'></a></p></div>"
					selhtml=selhtml+"<div class='favpad' id='favct'><div class='favmusicname'>"+reobj.MusicName+"</div>"
					selhtml=selhtml+"<div class='selbox'>收藏到：<span id='selid'></span></div><div id='selboxct'>"
					var exeu="";
					var selboxid,selboxname
					for (var i=0;i<reobj.Total;i++){
						if(i==reobj.Total-1){selboxid=reobj.FavList[i].ID;selboxname=reobj.FavList[i].Cname}
 						selhtml=selhtml+"<ul id='box"+reobj.FavList[i].ID+"'><a href=\"javascript:void(0)\" onclick=\"FAV.SetBoxid("+reobj.FavList[i].ID+",'"+reobj.FavList[i].Cname+"')\">"+reobj.FavList[i].Cname+"<span>("+reobj.FavList[i].Counts+")</span></a></ul>"	
					}
					selhtml=selhtml+"</div>"
					selhtml=selhtml+"<div class='favaddmenu'><input name=\"boxname\" type=\"text\" id=\"boxname\" size=\"50\" maxlength=\"50\" class='favinput' />"
					selhtml=selhtml+"<input type=\"button\" name=\"button\" id=\"button\" value=\"添加并使用\" onclick=\"FAV.AddBox()\" class='favbutton' /></div>"
					selhtml=selhtml+"<div class='favcontorl' ><ul><input type=\"button\" name=\"button\" id=\"button\" value=\"确定收藏\" class='rebutton' onclick=\"FAV.Save()\"/><input type=\"button\" name=\"button\" id=\"button\" value=\"取消收藏\" class='huibutton' onclick=\"FAV.Hide()\"/></ul><ul id='tshtml'></ul></div></div>"
 					$("#favbox").html(selhtml);
					FAV.Show();
					FAV.SetBoxid(selboxid,selboxname);
 					break;
			   default :
			} 
 	
		}
		function timeo(){alert("请求超时，请重试!")}   
	},
	ShowMsg:function(num,curstr){
		 $("#tshtml").html("<div class='e"+num+"'>"+curstr+"</div>")
	},
	Loading:function(){
		 $("#tshtml").html("<img src='/images/load.gif'>");
	},
	AddBox:function(){
		this.Loading()
		boxname=$("#boxname").val()
		if (boxname.length<2){
			this.ShowMsg(0,"音乐盒名称不合规范(2-50)位!")
			return false;
		}
 		var ajax = new AJAXRequest();
		ajax.async = true;
		ajax.timeout = 5e3;
		ajax.ontimeout = timeo;
		ajax.oncomplete = callback;
		ajax.get("/user/usercollect.asp?action=addsave&cname="+escape(boxname));
		function callback(obj) {
			var re =trim(obj.responseText);
			eval("var reobj="+re);
			switch (reobj.Result) {
				case 101:
					this.ShowMsg(0,"音乐盒名称不和规范(2-50)位!");
					break;
				case 102:
					this.ShowMsg(0,"您最多只能创建10个音乐盒!");
				case 200:
					var thisid=FAV.Musicid;
					FAV.SelFav(thisid);
			default :
			} 
 	
		}
		function timeo(){alert("请求超时，请重试!")}   
	},
	Save:function(){
		this.Loading();
		var musicid=this.Musicid;var boxid=this.Boxid;
		var ajax = new AJAXRequest();
		ajax.async = true;
		ajax.timeout = 5e3;
		ajax.ontimeout = timeo;
		ajax.oncomplete = callback;
		ajax.get("/user/fav.asp?action=addfav&musicid="+musicid+"&boxid="+boxid);
		function callback(obj) {
			var re =trim(obj.responseText);
			eval("var reobj="+re);
			switch (reobj.Result) {
				case 101:
					FAV.ShowMsg(0,reobj.Info)
					break;
				case 200:
 					var htmls="<div class='favsuc1'> "+reobj.MusicName+" <div><div class='favsuc2'><img src='/images/check1.gif' align='absmiddle'> 已收藏成功！&nbsp;<span id='favsec'>3</span>秒后关闭</div><div class='favsuc3'><a href='/user/musicbox.asp?id="+boxid+"'>查看音乐盒</a></div>"
 					$("#favct").html(htmls);
					FAV.SetIsHide(0);
 					var timerx =  window.setInterval(function autoclose(){
						var s=parseInt($("#favsec").html());
						s=s-1;
						if (s==0){
							if (FAV.IsHide==0){ FAV.Hide() }
							clearInterval(timerx)
						}else{
							$("#favsec").html(s);
						}
 					},1000);
  					break;
			default :
			} 
 		}
		function timeo(){alert("请求超时，请重试!")}   
		 
	},
	Collect:function(id,favid){
		var ajax = new AJAXRequest();
		ajax.async = true;
		ajax.timeout = 5e3;
		ajax.ontimeout = timeo;
		ajax.oncomplete = callback;
		ajax.get("/user/fav.asp?action=addfav&musicid="+id+"&favid="+favid);
		function callback(obj) {
			var re =trim(obj.responseText);
			eval("var reobj="+re);
			switch (reobj.Result) {
 			   case 200:
					break;
			   case 201:
					var selhtml="<div class='seltitle'><ul>舞曲收藏</ul><p class='selclo' onclick='FAV.Hide()'></p></div><div class='selct'>"
					for (var i=0;i<reobj.Total;i++){
						selhtml=selhtml+"<a href=\"javascript:void(0)\" onclick=\"FAV.Collect()\">"+reobj.FavList[i].Cname+"<span>("+reobj.FavList[i].Counts+")</span></a></ul>"	
					}
					selhtml=selhtml+"</div>"
					$("#favbox").html(selhtml);
					FAV.Show()
					 
					break;
			   default :
			} 
 	
		}
		function timeo(){alert("请求超时，请重试!")}   
	},
	Show:function(){
		$("#overlay").height(document.body.scrollHeight);
		$("#overlay").width(document.body.scrollWidth);
		$("#overlay").fadeTo(200, 0.5);
		$("#favbox").show();
	},
	Hide:function() {
		$("#overlay").fadeOut(200);
		$("#favbox").hide();
	},
	MoveSel:function (thisboxid){
		var selmusicid=""
		$(".idc").each(function(){
			if ($(this).attr("checked")){
				if (selmusicid==""){selmusicid=$(this).val()}
				else{selmusicid+=","+$(this).val()}
			}
		});
		if (selmusicid!=""){
				var ajax = new AJAXRequest()
				ajax.get("/user/fav.asp?action=selbox", function(obj) {
					eval("var reobj="+obj.responseText)
					if(reobj.Result == 200){
						var sstr;
						if (selmusicid.search(",")>-1){
							arr=selmusicid.split(",")
							mcount=arr.length;
						}else{
							mcount=1
						}
						if (mcount>6){sstr=mcount+"首"}
						else{sstr=selmusicid}
						var selhtml="<div class='favmusicname'>已选舞曲："+sstr+"</div>";
						selhtml+="<div class='selbox'>移动到：<span id='selid'></span></div><div id='selboxct'>"
						for (var i=0;i<reobj.Total;i++){
							if(i==reobj.Total-1){selboxid=reobj.FavList[i].ID;selboxname=reobj.FavList[i].Cname}
							selhtml+="<ul id='box"+reobj.FavList[i].ID+"'><a href=\"javascript:void(0)\" onclick=\"FAV.SetBoxid("+reobj.FavList[i].ID+",'"+reobj.FavList[i].Cname+"')\">"+reobj.FavList[i].Cname+"<span>("+reobj.FavList[i].Counts+")</span></a></ul>"	
						}
						selhtml+="</div><div class='favmovecontorl' ><ul><input type=\"button\" name=\"button\" id=\"button\" value=\"确定移动\" class='rebutton' onclick=\"FAV.MoveSave('"+selmusicid+"','"+thisboxid+"')\"/>"
						selhtml+="&nbsp;&nbsp;<input type=\"button\" name=\"button\" id=\"button\" value=\"取消\" class='huibutton' onclick=\"HideScbox()\"/></ul><ul id='tshtml'></ul></div></div>"
 						$("#sccontent").html(selhtml);
						ShowScbox();
					}
				});
		}else{alert('请先选择舞曲!')}
	},
	MoveSave:function(curmusicid,oldbox){
		this.Loading();
		if (this.Boxid==0){this.ShowMsg(0,'请选择目标音乐盒!')}
		else{
			var newbox=this.Boxid;
			var ajax = new AJAXRequest()
			ajax.get("/user/fav.asp?action=movebox&oldbox="+oldbox+"&newbox="+newbox+"&musicid="+curmusicid, function(obj) {
				eval("var reobj="+obj.responseText)
				if(reobj.Result == 200){
 					var htmls="<div class='favsuc2'><img src='/images/check1.gif' align='absmiddle'>移动已成功！&nbsp;<span id='favsec'>3</span>秒后关闭</div>"
 					$("#sccontent").html(htmls);
  					var timerx =  window.setInterval(function autoclose(){
						var s=parseInt($("#favsec").html());
						s=s-1;
						if (s==0){
							location.reload();
							clearInterval(timerx)
						}else{
							$("#favsec").html(s);
						}
 					},1000);
				}else{
					FAV.ShowMsg(0,reobj.Info)
				}
			});
			
		}
	}
}
