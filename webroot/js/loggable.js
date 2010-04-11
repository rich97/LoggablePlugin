/* Base64 encode / decode
*  http://www.webtoolkit.info/
*/
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(input){var output="";var chr1,chr2,chr3,enc1,enc2,enc3,enc4;var i=0;input=Base64._utf8_encode(input);while(i<input.length){chr1=input.charCodeAt(i++);chr2=input.charCodeAt(i++);chr3=input.charCodeAt(i++);enc1=chr1>>2;enc2=((chr1&3)<<4)|(chr2>>4);enc3=((chr2&15)<<2)|(chr3>>6);enc4=chr3&63;if(isNaN(chr2)){enc3=enc4=64;}else if(isNaN(chr3)){enc4=64;}
output=output+
this._keyStr.charAt(enc1)+this._keyStr.charAt(enc2)+
this._keyStr.charAt(enc3)+this._keyStr.charAt(enc4);}
return output;},_utf8_encode:function(string){string=string.replace(/\r\n/g,"\n");var utftext="";for(var n=0;n<string.length;n++){var c=string.charCodeAt(n);if(c<128){utftext+=String.fromCharCode(c);}
else if((c>127)&&(c<2048)){utftext+=String.fromCharCode((c>>6)|192);utftext+=String.fromCharCode((c&63)|128);}
else{utftext+=String.fromCharCode((c>>12)|224);utftext+=String.fromCharCode(((c>>6)&63)|128);utftext+=String.fromCharCode((c&63)|128);}}
return utftext;}}
function loggable(code,url){url+="/code:"+code;if(navigator!=null){if(navigator.systemLanguage!=null){url+="/64lang:"+Base64.encode(navigator.systemLanguage);}else if(navigator.userLanguage!=null){url+="/64lang:"+Base64.encode(navigator.userLanguage);}}
if(screen!=null){if(screen.width!=null){url+="/width:"+screen.width;}
if(screen.height!=null){url+="/height:"+screen.height;}
if(screen.availWidth!=null){url+="/avwidth:"+screen.availWidth;}
if(screen.availHeight!=null){url+="/avheight:"+screen.availHeight;}
if(screen.colorDepth!=null){url+="/colour:"+screen.colorDepth;}
document.getElementById('loggable').innerHTML='<img src="'+url+'">';}}
loggable(LogCode,LogUrl);
