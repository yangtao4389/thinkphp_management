function wu_readcookie(name){
  var cookieValue = "";
  var search = name + "=";
  if(document.cookie.length > 0){ 
    offset = document.cookie.indexOf(search);
    if (offset != -1){ 
      offset += search.length;
      end = document.cookie.indexOf(";", offset);
      if (end == -1) end = document.cookie.length;
      cookieValue = unescape(document.cookie.substring(offset, end))
    }
  }
  return cookieValue;
}

function wu_writecookie(name, value, minite){
  var expire = "";
  if(minite != null){
    expire = new Date((new Date()).getTime() + minite * 60000);
    expire = "; expires=" + expire.toGMTString()+";path=/";
  }
  document.cookie = name + "=" + escape(value) + expire;
}
function ispopup(){
	var ispop = wu_readcookie(popcookies); 
 
 	if(ispop != 1) {ispop=0;}
	return ispop;
}
 
if(refreshpop){
	document.write("<script language=javascript src='"+jspath+"popup.js'></script>");
}else{
 
	if (ispopup()==0){
		document.write("<script language=javascript src='"+jspath+"popup.js'></script>");
	}
}
