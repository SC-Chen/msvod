var aimm = {
init : function(){
aimm.sorts.init();
aimm.modslider.init();
aimm.slider.init();
aimm.tabs.init();
aimm.items.init();
aimm.plot.init();
aimm.fav.init();
aimm.menufixed.init();
aimm.lazyload.init();
},sorts : {
init : function(){
$(".open").hover(
function () {
$(".sub-menu").show();
},function () {
$(".sub-menu").hide();
}
);
}
},modslider : {
init : function(){
$(".mod-slider").bind("mouseover",function(){
$(this).addClass("hover");
});
$(".mod-slider").bind("mouseout",function(){
$(this).removeClass("hover");
});
}
},slider : {
init : function(){
var $cur = 1;
var $i = 1;
var $len = $('.slide-show-ctn').length;
var $pages = Math.ceil($len / $i);
var $w = $('.mod-slider').width();
var $showbox = $('#slider-show');
var $pre = $('.slide-left-btn');
var $next = $('.slide-right-btn');
var $autoFun;
$(".mod-rep-img").height();
//@Mr.Think***调用自动滚动
autoSlide();
//@Mr.Think***向前滚动
$pre.click(function(){
if (!$showbox.is(':animated')) {
if ($cur == 1) { 
$showbox.animate({
left: '-=' + $w * ($pages - 1)
}, 800);
$cur = $pages;
}
else {
$showbox.animate({
left: '+=' + $w
}, 800);
$cur--;
}
}
});
$next.click(function(){
if (!$showbox.is(':animated')) { //判断展示区是否动画
if ($cur == $pages) {  //在最后一个版面时,再向后滚动到第一个版面
$showbox.animate({
left: 0
}, 800); //改变left值,切换显示版面,500(ms)为滚动时间,下同
$cur = 1; //初始化版面为第一个版面
}
else {
$showbox.animate({
left: '-=' + $w
}, 800);//改变left值,切换显示版面
$cur++; //版面数累加
}
}
});
function autoSlide(){
$next.trigger('click');
$autoFun = setTimeout(autoSlide, 6000);
}
function clearAuto(){
clearTimeout($autoFun);
}
}
},tabs : {
init : function(){
$(".in-grid li:first-child").addClass("cur");
$(".channel-ctn").find(".channel-show:first-child").show();
$(".channel-ctn .channel-show").attr("id", function(){return idNumber("channel-")+ $(".channel-ctn .channel-show").index(this)});
$(".in-grid li").click(function(){
var c = $(".in-grid li");
var index = c.index(this);
var p = idNumber("channel-");
show(c,index,p);
});

function show(channelMenu,num,prefix){
var content= prefix + num;
$('#'+content).siblings().hide();
$('#'+content).show();
channelMenu.eq(num).addClass("cur").siblings().removeClass("cur");
};

function idNumber(prefix){
var idNum = prefix;
return idNum;
};
}
},items : {
init : function(){
$(".preview").hover(
function () {
$(this).attr("class","preview hover");
},function () {
$(this).attr("class","preview");
}
);
}
},plot : {
init : function(){
$(".plot").hide();
$(function () {
$(window).scroll(function(){
if ($(window).scrollTop()>600){
$(".plot").fadeIn(1500);
}
else
{
$(".plot").fadeOut(1500);
}
});
$(".plot a").hover(function(){
$(this).animate({width:"70px"});
},function(){
$(this).animate({width:"50px"});
})
$(".plot a").click(function(){
var rel=$(this).attr("rel");
var pos=$(rel).offset().top;
$("html, body").animate({scrollTop:pos},1000);
})
});
}
},fav : {
init : function(){
$("#favorites,#favorites").click(
function () {
var ctrl = (navigator.userAgent.toLowerCase()).indexOf('mac') != -1 ? 'Command/Cmd' : 'CTRL';
if (document.all) {
window.external.addFavorite('http://www.97mm.net','\u0039\u0037\u7f8e\u7709')
} else if (window.sidebar) {
window.sidebar.addPanel('\u0039\u0037\u7f8e\u7709','http://www.97mm.net',"")
} else {
alert('\u6DFB\u52A0\u5931\u8D25\n\u60A8\u53EF\u4EE5\u5C1D\u8BD5\u901A\u8FC7\u5FEB\u6377\u952E'+ctrl+'+D\u52A0\u5165\u5230\u6536\u85CF\u5939~')
}
})
}
},menufixed : {
init : function(){
/*$(window).scroll(function(){
if ($(window).scrollTop()>100){
$(".main-nav").attr("class","main-nav fixed");
$(".main-menu-bg").attr("class","main-menu-bg js");
}
else
{
$(".main-nav").attr("class","main-nav");
$(".main-menu-bg").attr("class","main-menu-bg");
}
});*/
}
},lazyload : {
init : function(){
$("img").lazyload();
}
}
}

//登陆窗口显示
function readylogin() {
$('.msvod-popover-mask').fadeIn(100);
$('.msvod-popover').slideDown(200);
}
//登陆窗口关闭
function closelogin() {
$('.msvod-popover-mask').fadeOut(10);
$('.msvod-popover').slideUp(20);
}
//注册窗口显示
function readyreg() {
$('.reg-popover-mask').fadeIn(100);
$('.reg-popover').slideDown(200);
}
//注册窗口关闭
function closereg() {
$('.reg-popover-mask').fadeOut(10);
$('.reg-popover').slideUp(20);
}
var tablink_idname = new Array("tablink","anotherlink")
var tabcontent_idname = new Array("tabcontent","anothercontent") 
var tabcount = new Array("2","2")
var loadtabs = new Array("1","5")  
var autochangemenu = 2;
var changespeed = 3;
var stoponhover = 0;
function easytabs(menunr, active) {if (menunr == autochangemenu){currenttab=active;}if ((menunr == autochangemenu)&&(stoponhover==1)) {stop_autochange()} else if ((menunr == autochangemenu)&&(stoponhover==0))  {counter=0;} menunr = menunr-1;for (i=1; i <= tabcount[menunr]; i++){document.getElementById(tablink_idname[menunr]+i).className='tab'+i;document.getElementById(tabcontent_idname[menunr]+i).style.display = 'none';}document.getElementById(tablink_idname[menunr]+active).className='tab'+active+' tabactive';document.getElementById(tabcontent_idname[menunr]+active).style.display = 'block';}var timer; counter=0; var totaltabs=tabcount[autochangemenu-1];var currenttab=loadtabs[autochangemenu-1];function start_autochange(){counter=counter+1;timer=setTimeout("start_autochange()",1000);if (counter == changespeed+1) {currenttab++;if (currenttab>totaltabs) {currenttab=1}easytabs(autochangemenu,currenttab);restart_autochange();}}function restart_autochange(){clearTimeout(timer);counter=0;start_autochange();}function stop_autochange(){clearTimeout(timer);counter=0;}

window.onload=function(){
var menucount=loadtabs.length; var a = 0; var b = 1; do {easytabs(b, loadtabs[a]);  a++; b++;}while (b<=menucount);
if (autochangemenu!=0){start_autochange();}
}
 
