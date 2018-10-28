//mscms_api资源库
var jump = '';
if(jumpurl!='0'){
jump = '<a href="'+jumpurl+'" style="color:#FF0000;font-weight:bold">上次有采集任务没有完成，是否接着采集?</a>';
}
//资源列表
var mscms_zylist = [
{
'name':'77资源站【api.77x6.com】【混合资源(无需播放器)】',
'apiurl':'aHR0cDovL2FwaS43N3g2LmNvbS9pbmMvYXBpLnBocA',
'ac':'77x6',
'rid':0,
'info':'由77资源站api.77x6.com提供,保持同步更新~!'
},
{
'name':'『XiGua』西瓜影音资源 www.myzyzy.com',
'apiurl':'aHR0cDovL3d3dy5teXp5enkuY29tL2FwaS9tYXguYXNw',
'ac':'xgvod',
'rid':0,
'info':'由西瓜影音资源 www.myzyzy.com提供,保持同步更新~!'
},
{
'name':'吉吉资源网【www.jijizy.com】',
'apiurl':'aHR0cDovL2FwaS5qaWppenkuY29tL2luYy9hcGkuYXNw',
'ac':'jijizy',
'rid':0,
'info':'由吉吉资源网www.jijizy.com提供,保持同步更新~!'
},
{
'name':'吉吉资源网2【www.jjyyzy.com】',
'apiurl':'aHR0cDovL3d3dy5qanl5enkuY29tL2luYy9hcGkuYXNw',
'ac':'jjyyzy',
'rid':0,
'info':'由吉吉资源网www.jjyyzy.com提供,保持同步更新~!'
},
{
'name':'91资源网【www.91zy.cc】【混合资源】',
'apiurl':'aHR0cDovL3d3dy45MXp5LmNjL2luYy9hcGlfbWFjY21zLmFzcA',
'ac':'91zy',
'rid':0,
'info':'由91资源网www.91zy.cc提供,保持同步更新~!'
}
]
var mscms_fsd = [
{
'name':'【粉丝多资源】西瓜影音',
'apiurl':'aHR0cDovL3d3dy5mZW5zaXp5LmNvbS9hcGkvbWF4NC5hc3A',
'ac':'fensizy',
'rid':1,
'info':'粉丝多资源【www.fensizy.com】提供,保持同步更新~!'
},
{
'name':'【粉丝多资源】先锋影音',
'apiurl':'aHR0cDovL3d3dy5mZW5zaXp5LmNvbS9hcGkvbWF4NC5hc3A',
'ac':'fensizy',
'rid':2,
'info':'粉丝多资源【www.fensizy.com】提供,保持同步更新~!'
},
{
'name':'【粉丝多资源】吉吉影音',
'apiurl':'aHR0cDovL3d3dy5mZW5zaXp5LmNvbS9hcGkvbWF4NC5hc3A',
'ac':'fensizy',
'rid':3,
'info':'粉丝多资源【www.fensizy.com】提供,保持同步更新~!'
},
{
'name':'【粉丝多资源】乐视视频',
'apiurl':'aHR0cDovL3d3dy5mZW5zaXp5LmNvbS9hcGkvbWF4NC5hc3A',
'ac':'fensizy',
'rid':4,
'info':'粉丝多资源【www.fensizy.com】提供,保持同步更新~!'
},
{
'name':'【粉丝多资源】优酷视频',
'apiurl':'aHR0cDovL3d3dy5mZW5zaXp5LmNvbS9hcGkvbWF4NC5hc3A',
'ac':'fensizy',
'rid':5,
'info':'粉丝多资源【www.fensizy.com】提供,保持同步更新~!'
}
]
var mscms_fgzy = [
{
'name':'【凡高资源】全部资源',
'apiurl':'aHR0cDovL2lkLmR1b2R1b3R2LmNvbS9pbmMvYXBpLnBocA',
'ac':'fgzy',
'rid':0,
'info':'ID在线播放和ID解析资源,保持同步更新~!'
},
{
'name':'【凡高资源】优酷资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpeW91a3UucGhw',
'ac':'fgzy',
'rid':0,
'info':'优酷在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】土豆资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpdHVkb3UucGhw',
'ac':'fgzy',
'rid':0,
'info':'土豆在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】聚力资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpcHB0di5waHA',
'ac':'fgzy',
'rid':0,
'info':'PPTV聚力在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】搜狐资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpc29odS5waHA',
'ac':'fgzy',
'rid':0,
'info':'搜狐在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】腾讯资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpcXEucGhw',
'ac':'fgzy',
'rid':0,
'info':'腾讯在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】乐视资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpbGV0di5waHA',
'ac':'fgzy',
'rid':0,
'info':'乐视在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】奇艺资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpcWl5aS5waHA',
'ac':'fgzy',
'rid':0,
'info':'奇艺在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】电影网资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpbTE5MDUucGhw',
'ac':'fgzy',
'rid':0,
'info':'电影网在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】芒果资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpbWd0di5waHA',
'ac':'fgzy',
'rid':0,
'info':'芒果在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】风行资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpZnVuc2hpb24ucGhw',
'ac':'fgzy',
'rid':0,
'info':'风行在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】华数资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpd2FzdS5waHA',
'ac':'fgzy',
'rid':0,
'info':'华数在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】响巢资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpa2Fua2FuLnBocA',
'ac':'fgzy',
'rid':0,
'info':'响巢在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】CNTV资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpY250di5waHA',
'ac':'fgzy',
'rid':0,
'info':'CNTV在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】凤凰资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpaWZlbmcucGhw',
'ac':'fgzy',
'rid':0,
'info':'凤凰在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】新浪资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpc2luYS5waHA',
'ac':'fgzy',
'rid':0,
'info':'新浪在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】迈视资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpbWF4dHYucGhw',
'ac':'fgzy',
'rid':0,
'info':'迈视在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】哔哩哔哩弹幕资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpYmlsaWJpbGkucGhw',
'ac':'fgzy',
'rid':0,
'info':'哔哩哔哩弹幕在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】AcFun弹幕资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpYWNmdW4ucGhw',
'ac':'fgzy',
'rid':0,
'info':'AcFun弹幕在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】非凡影音资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpZmZoZC5waHA',
'ac':'fgzy',
'rid':0,
'info':'非凡影音,非凡影音需要安装P2P播放器~!'
},
{
'name':'【凡高资源】音悦台资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpeWlueXVldGFpLnBocA',
'ac':'fgzy',
'rid':0,
'info':'音悦台在线播放资源,保持同步更新~!'
},
{
'name':'【凡高资源】暴风1080P资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpaGRiYW9mZW5nMTA4MFAucGhw',
'ac':'fgzy',
'rid':0,
'info':'暴风1080P资源,保持同步更新~!'
},
{
'name':'【凡高资源】暴风720P资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpaGRiYW9mZW5nNzIwUC5waHA',
'ac':'fgzy',
'rid':0,
'info':'暴风720P资源,保持同步更新~!'
},
{
'name':'【凡高资源】暴风480P资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpaGRiYW9mZW5nNDgwUC5waHA',
'ac':'fgzy',
'rid':0,
'info':'暴风480P资源,保持同步更新~!'
},
{
'name':'【凡高资源】暴风240P资源',
'apiurl':'aHR0cDovL2J0LmR1b2R1b3R2LmNvbS9pbmMvYXBpaGRiYW9mZW5nMjQwUC5waHA',
'ac':'fgzy',
'rid':0,
'info':'暴风240P资源,保持同步更新~!'
}
]



document.write('<table class="tablelist">');
document.write('<thead>');
document.write('<tr align="center">');
document.write('<th width="50">编号</th>');
document.write('<th width="350">API资源站名称</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="*">'+jump+'</th>');
document.write('</tr>');
document.write('</thead>');

document.write('<tbody>');

for(var i=0;i<mscms_zylist.length;i++){
var xu=(i<11) ? '0'+(i+1): (i+1);
document.write('<tr>');
document.write('<td>'+xu+'、</td>');
document.write('<td><a class="logs" href="?api='+mscms_zylist[i]['apiurl']+'&ac='+mscms_zylist[i]['ac']+'&rid='+mscms_zylist[i]['rid']+'">'+mscms_zylist[i]['name']+'</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_zylist[i]['apiurl']+'&ac='+mscms_zylist[i]['ac']+'&rid='+mscms_zylist[i]['rid']+'">进入查看</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_zylist[i]['apiurl']+'&ac='+mscms_zylist[i]['ac']+'&op=day&do=caiji&rid='+mscms_zylist[i]['rid']+'" style="color:red">采集当天</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_zylist[i]['apiurl']+'&ac='+mscms_zylist[i]['ac']+'&op=week&do=caiji&rid='+mscms_zylist[i]['rid']+'" style="color:green">采集本周</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_zylist[i]['apiurl']+'&ac='+mscms_zylist[i]['ac']+'&op=all&do=caiji&rid='+mscms_zylist[i]['rid']+'" style="color:#ff6600">采集全部</a></td>');
document.write('<td>&nbsp;'+mscms_zylist[i]['info']+'</td>');
document.write('</tr>');
}

document.write('<thead>');
document.write('<tr align="center">');
document.write('<th width="50">编号</th>');
document.write('<th width="350">粉丝多资源列表</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="*">'+jump+'</th>');
document.write('</tr>');
document.write('</thead>');
for(var i=0;i<mscms_fsd.length;i++){
var xu=(i<11) ? '0'+(i+1): (i+1);
document.write('<tr>');
document.write('<td>'+xu+'、</td>');
document.write('<td><a class="logs" href="?api='+mscms_fsd[i]['apiurl']+'&ac='+mscms_fsd[i]['ac']+'&rid='+mscms_fsd[i]['rid']+'">'+mscms_fsd[i]['name']+'</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fsd[i]['apiurl']+'&ac='+mscms_fsd[i]['ac']+'&rid='+mscms_fsd[i]['rid']+'">进入查看</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fsd[i]['apiurl']+'&ac='+mscms_fsd[i]['ac']+'&op=day&do=caiji&rid='+mscms_fsd[i]['rid']+'" style="color:red">采集当天</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fsd[i]['apiurl']+'&ac='+mscms_fsd[i]['ac']+'&op=week&do=caiji&rid='+mscms_fsd[i]['rid']+'" style="color:green">采集本周</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fsd[i]['apiurl']+'&ac='+mscms_fsd[i]['ac']+'&op=all&do=caiji&rid='+mscms_fsd[i]['rid']+'" style="color:#ff6600">采集全部</a></td>');
document.write('<td>&nbsp;'+mscms_fsd[i]['info']+'</td>');
document.write('</tr>');
}

document.write('<thead>');
document.write('<tr align="center">');
document.write('<th width="50">编号</th>');
document.write('<th width="350">凡高资源列表</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="100">&nbsp;</th>');
document.write('<th width="*">'+jump+'</th>');
document.write('</tr>');
document.write('</thead>');
for(var i=0;i<mscms_fgzy.length;i++){
var xu=(i<11) ? '0'+(i+1): (i+1);
document.write('<tr>');
document.write('<td>'+xu+'、</td>');
document.write('<td><a class="logs" href="?api='+mscms_fgzy[i]['apiurl']+'&ac='+mscms_fgzy[i]['ac']+'&rid='+mscms_fgzy[i]['rid']+'">'+mscms_fgzy[i]['name']+'</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fgzy[i]['apiurl']+'&ac='+mscms_fgzy[i]['ac']+'&rid='+mscms_fgzy[i]['rid']+'">进入查看</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fgzy[i]['apiurl']+'&ac='+mscms_fgzy[i]['ac']+'&op=day&do=caiji&rid='+mscms_fgzy[i]['rid']+'" style="color:red">采集当天</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fgzy[i]['apiurl']+'&ac='+mscms_fgzy[i]['ac']+'&op=week&do=caiji&rid='+mscms_fgzy[i]['rid']+'" style="color:green">采集本周</a></td>');
document.write('<td><a class="logs" href="?api='+mscms_fgzy[i]['apiurl']+'&ac='+mscms_fgzy[i]['ac']+'&op=all&do=caiji&rid='+mscms_fgzy[i]['rid']+'" style="color:#ff6600">采集全部</a></td>');
document.write('<td>&nbsp;'+mscms_fgzy[i]['info']+'</td>');
document.write('</tr>');
}


document.write('</table>');


