function $Showhtml(){
    document.getElementById('playad').style.display = "none";
    player = '<iframe id="ckplayer" src="ckplayer.html" width="100%" height="' + height + '" frameborder="0" scrolling="no"></iframe>';
    document.getElementById('playlist').innerHTML = player;
}
if(parent.ms_adloadtime){
	setTimeout("$Showhtml();",parent.ms_adloadtime*1000);
}

