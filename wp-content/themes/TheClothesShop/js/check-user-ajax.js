var xmlhttp;

function showUser(str,subfolder)
{
	if (str.length==0)
	  {
	  document.getElementById("userHint").innerHTML="";
	  return;
	  }
	  
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Your browser does not support XMLHTTP!");
	  return;
	  }
	  
	  
	if(subfolder != "none"){
		subfolder 		= str_replace('##slash##', '/',subfolder);					//if slashes are left unmasked, this might cause 
																					// 'regular expression missing flag error'
		var addition 	= "/" + subfolder;
	}else{
		var addition = "";
	}  
	  
	var url=NWS_template_directory +"/check-user.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=stateChangedUser;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}



function stateChangedUser()
{
if (xmlhttp.readyState==4)
  {
  document.getElementById("userHint").innerHTML=xmlhttp.responseText;
  }
}

function str_replace(search, replace, subject, count) {

    var i = 0, j = 0, temp = '', repl = '', sl = 0, fl = 0,
            f = [].concat(search),
            r = [].concat(replace),
            s = subject,
            ra = r instanceof Array, sa = s instanceof Array;
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }

    for (i=0, sl=s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j=0, fl=f.length; j < fl; j++) {
            temp = s[i]+'';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length-s[i].length)/f[j].length;}
        }
    }
    return sa ? s : s[0];
}