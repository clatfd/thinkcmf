function asplay(word,mp3){
	var isNSupportFlash = !! document.createElement("audio").canPlayType && document.createElement("audio").canPlayType("audio/mpeg") && navigator.userAgent.indexOf("Maxthon") < 0;
	if(isNSupportFlash){
		var sound =  new Audio(mp3);
		sound.src = mp3;
		
		sound.addEventListener("error", function(_event) {
   			toastr.warning("<strong>Can not find \""+mp3.slice(0,-4)+"\"in audio library!</strong>");
		});
		
		sound.addEventListener("loadedmetadata", function(_event) {
   			sound.play();
			toastr.info("<strong>\""+word+"\" <br/><a href='javascript:asplay(\""+word+"\",\""+mp3+"\")'>Play again!</a></strong>");
		});
		
	}else{
			// clearTimeout(timer);
			// timer = setTimeout(function(){player_v1_callback(mp3);return false;}, 100);	
	}
}

//show object property
function sop(Obj) 
{ 
	var PropertyList=''; 
	var PropertyCount=0; 
	for(i in Obj)
	{	 
	if(Obj.i !=null) 
	PropertyList=PropertyList+i+'属性：'+Obj.i+'\r\n'; 
	else 
	PropertyList=PropertyList+i+'方法\r\n'; 
	}
	alert(PropertyList); 
} 

function getPar(par){ 
     var local_url = document.location.href;  
     var get = local_url.indexOf(par +"="); 
     if(get == -1){ 
         return false;    
    }    
    var get_par = local_url.slice(par.length + get + 1);     
    var nextPar = get_par.indexOf("&"); 
    if(nextPar != -1){ 
      get_par = get_par.slice(0, nextPar); 
     } 
     return get_par; 
} 

shuffle = function(o){ 
	for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
	return o;
};

function urlfit(str){
	//toastr.info("urlfit: change from "+str);
	str=str.replace(/%/g,"%25");
	str=str.replace(/&/g,"%26");    	
	str=str.replace(/#/g,"%23");
	str=str.replace(/=/g,"%3D");
	//toastr.info("urlfit: change to "+str);
	return str;
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}