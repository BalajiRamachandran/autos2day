var xmlhttp;

function showHint(str,subfolder)
{
	if (str.length==0){
	  document.getElementById("txtHint").innerHTML="";
	  return;
	}
	  
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Your browser does not support XMLHTTP!");
	  return;
	  }
	  
	if(subfolder != "none"){
		var addition = "/" + subfolder;
	}else{
		var addition = "";
	}
	  
	var url=NWS_template_directory +"/check-email.php";
	url=url+"?q="+str;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=stateChangedEmail;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}



function stateChangedEmail()
{
if (xmlhttp.readyState==4)
  {
	document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
  }
}



function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}