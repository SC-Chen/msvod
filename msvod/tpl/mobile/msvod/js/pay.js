// JavaScript Document
function setCookie(name, value, day) {
    var exp = new Date();
    exp.setTime(exp.getTime() + day * 24 * 60 * 60 * 1000);
    document.cookie = name + "= " + escape(value) + ";expires= " + exp.toGMTString() + ';path=/;';
}


/*app*/

function browserRedirect() { 
	var sUserAgent= navigator.userAgent.toLowerCase(); 
	var bIsIpad= sUserAgent.match(/ipad/i) == "ipad"; 
	var bIsIphoneOs= sUserAgent.match(/iphone os/i) == "iphone os"; 
	var bIsMidp= sUserAgent.match(/midp/i) == "midp"; 
	var bIsUc7= sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4"; 
	var bIsUc= sUserAgent.match(/ucweb/i) == "ucweb"; 
	var bIsAndroid= sUserAgent.match(/android/i) == "android"; 
	var bIsCE= sUserAgent.match(/windows ce/i) == "windows ce"; 
	var bIsWM= sUserAgent.match(/windows mobile/i) == "windows mobile"; 
	
	if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) { 
		
	} else { 
		window.location= '/index.php';
	} 
} 

browserRedirect(); 

	
	
	
function getCookie(objName) {
    var arrStr = document.cookie.split("; ");
    for (var i = 0; i < arrStr.length; i++) {
        var temp = arrStr[i].split("=");
        if (temp[0] == objName)
            return unescape(temp[1])
    }
}

function getQueryString(name, d) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return unescape(r[2]);
    return d;
}

function getDevice() {
    var sUserAgent = navigator.userAgent.toLowerCase();
    var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
    var bIsIphoneOs = sUserAgent.match(/iphone/i) == "iphone";
    var bIsWeixin = sUserAgent.match(/micromessenger/i) == "micromessenger";
    var bIsMidp = sUserAgent.match(/midp/i) == "midp";
    var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
    var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
    var bIsAndroid = sUserAgent.match(/android/i) == "android";
    var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
    var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
    if (bIsWeixin) {
        return "weixin";
    } else if (bIsAndroid) {
        return "android";
    } else if (bIsIpad || bIsIphoneOs) {
        return "ios";
    } else
        return "pc"
}

function isSafari(){
    var sUserAgent = navigator.userAgent.toLowerCase();
    return sUserAgent.match(/safari/i) == "safari";   
}


function getUrl(m) {
    url = "javascript:pay();"
    return url;
}

function getId() {
    var _sid = getQueryString("sid"), _aid = getQueryString("aid"), _noapp = getQueryString("noapp");
    if (isNaN(_sid) || typeof (_sid) == 'undefined' || _sid == 'undefined' || _sid == null) {
        _sid = getCookie("sid");
        if (isNaN(_sid) || typeof (_sid) == 'undefined' || _sid == 'undefined' || _sid == null) {
            _sid = 1;
        }
    } else {
        setCookie("sid", _sid, 30);
    }
    if (isNaN(_aid) || typeof (_aid) == 'undefined' || _aid == 'undefined' || _aid == null) {
        _aid = getCookie("aid");
        if (isNaN(_aid) || typeof (_aid) == 'undefined' || _aid == 'undefined' || _aid == null) {
            _aid = 1; 
        }
    } else {
        setCookie("aid", _aid, 30);
    }
    aid = _aid;
    sid = _sid;
    if (_noapp == '1') {
        setCookie('noapp', 1, 30);
    }
}


function pay() {    
    var parentClass='layermmain';
    if ($("."+parentClass+" .popup").hasClass("active") || vipType >= resourceType)
        return false;   
    popPayDiv();

    var docH = $(document).height();     
    $("."+parentClass+" .popup").addClass("active");       
    var checked = $("."+parentClass+" input[name='vipType']:checked").val();

}



function loadedHandler() {
    if (CKobject.getObjectById('ckplayer_a1').getType()) {
        CKobject.getObjectById('ckplayer_a1').addListener('ended', endHandler);
    } else {
        CKobject.getObjectById('ckplayer_a1').addListener('ended', 'endHandler');
    }
}

function endHandler() {
    $("#a1").addClass("end-trigger");
    if (vipType != 2)
        pay();
    var timer = setInterval(function () {
        if (vipType != 2)
            pay();
    }, 3000);

}


