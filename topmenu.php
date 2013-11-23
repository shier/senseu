<?php
session_start();
$_SESSION['userloginMode']=$_COOKIE['back_userid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/main.css" type="text/css" rel="stylesheet" />
<style type="text/css">
.areaFrame {width:1000px;height:112px;}
a:link {color: #777777; text-decoration:none;} //未访问
a:active {color: #777777; } //激活
a:visited {color:#777777;text-decoration:none;} //已访
a:hover {color: #2d2d2d; text-decoration:underline;} //鼠标移  

.blankRow {height:20px; font-size:12px; color:#ff0000; padding-left:10px; vertical-align:top;}
.btnHand {cursor:pointer;}
.up_loginInput {	
	width:124px;
	height:27px;
	line-height:27px;
	border:0;
	color:#cccccc;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;
}
.up_loginInputBack {	width:136px;
	height:29px;
	text-align:center;
	background:url(images/inp_bg.png) no-repeat;
	padding-top:1px;
}
.inputArea {position:relative;
	float:right;
	top:5px;
	right:0px;
	text-align:right;
}
#logo {
	width: 120px;
	height: 25px;
	top: 43px;
	left: 10px;
	position: relative;
	cursor: pointer;
}

#textMenu {
	position: absolute;
	right: 135px;
	width: 680px;
	top: 87px;
	left: 321px;
	text-align: right;
	color: #3e3f41;
	height: 21px;
}
.homeMenu{text-align:right; padding-left:70px; color:black; cursor:default;}
.homeMenuBtn{cursor:pointer; color:#868686}
body,td,th {
	font-family: Conv_KlavikaRegular-Plain, Arial, sans-serif;
}

#alreadylogin{display:none}
#newlogin{display:nnone;}

</style>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/topmenu.js"></script>
</head>

<body >
<div id="topMenuArea" class="areaFrame">
 
    
  <div class="inputArea" id="newlogin">
      <table cellpadding="0" cellspacing="0" >
        <tr >
          <td width="10"><input type="hidden" value="<?php echo $mode; ?>" id="G_mode" /></td>
          <td  class="up_loginInputBack"><input type="text" id="up_loginEmail" value="email" class="up_loginInput" /></td>
          <td width="6"></td>
          <td class="up_loginInputBack" ><input type="text" id="passwordt" value="password" class="up_loginInput"  />
            <input type="password" id="up_loginPass" value="" class="up_loginInput"  style="display:none" /></td>
          <td width="9"></td>
          <td width="47" align="center"><img src="images/up_login.png" alt="" width="47" height="27" class="btnHand" id="up_btnLogin" /></td>
          <td width="6"></td>
          <td width="48" id="regtable"><img src="images/btn_reg.png" alt="" width="68" height="27" id="reg" style="cursor:pointer" /></td>
        </tr>
        <tr>
          <td colspan="4" class="blankRow" id="up_loginWrong" align="left"></td>
        </tr>
      </table>
    </div>
     <div class="inputArea" id="alreadylogin">
      <table cellpadding="0" cellspacing="0" >
        <tr>
          <td class="G_smallText"><span id="btn_profile">My Profile</span></td>
          <td width="10"></td>
          <td class="G_smallText"><span id="btn_Guide">User Guide</span></td>
          <td width="10"></td>
          <td width="48"><img src="images/logout.png" alt="" name="logout" width="78" height="29" id="logout" style="cursor:pointer" /></td>
        </tr>
        
      </table>
    </div>
    <div id="logo"><img src="images/s-logo.png" alt="" width="133" height="44" /></div>
    <div id="textMenu">
      <table cellpadding="0" cellspacing="0" class="upMenu" align=right >
        <tr>
          <td class="homeMenu"><span id="menu1">HOME</span></td>
          <td   class="homeMenu"><span id="menu2">SENSE-U</span></td>
          <td  class="homeMenu"><span id="menu3">HOW IT WORKS</span></td>
          <td  class="homeMenu"><span id="menu4">PRE-ORDER</span></td>
        </tr>
      </table>
  </div>
  </div>


</body>
</html>
