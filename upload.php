<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>upload</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script language="javascript" src="js/swfobject.js"></script>
<script type="text/javascript">

	function updatedHead(headpic,ecode){
		$.cookie('back_ecode', ecode);
		
		parent.updatedHead(headpic)
	}
	function hidethis(){
		parent.hidethis();
		
	}	
	function writeFlash(){
	
		var flashvars = {ucode:$.cookie('back_ucode'),scode:$.cookie('back_scode'),ecode:$.cookie('back_ecode')};
		var params = {quality: "high",swLiveConnect:"true",menu: "false",allowScriptAccess: "sameDomain",allowFullScreen:"true",wmode:"opaque"};
		var attributes = {};
		swfobject.embedSWF("main.swf", "myContent", "389", "320", "8.0.0","expressInstall.swf", flashvars, params, attributes);
	
	}
	$(function(){
		writeFlash();
	});
</script>
<style>
body {margin:0px}
#myContent { width:389px;height:320px}
</style>
</head>
<body><div id="myContent"></div></body></html>
