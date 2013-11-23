<?php 
include("res/dbconnect.php");

$ucode=$_REQUEST['ucode'];
$scode=$_REQUEST['scode'];
$ecode=$_REQUEST['ecode'];
$source=$_REQUEST['source'];

checkuser($ucode,$scode,$ecode,$source);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$sql="SELECT a.unit, b.stepgoal, b.caloriesgoal, b.stepwidth FROM sensorinfo AS a, dailyvalue AS b WHERE a.id = b.sensorid and a.id=? and b.date=?";
//echo "SELECT a.unit, b.stepgoal, b.caloriesgoal, b.stepwidth FROM sensorinfo AS a, dailyvalue AS b WHERE a.id = b.sensorid and a.id=$scode and b.date='$now'";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $scode,$now);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $unit,$stepgoal,$caloriesgoal,$stepwidth);
$stmt->fetch();
$stmt->close();
$mysqli->close();  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>setup</title>
<link href="css/main.css" type="text/css" rel="stylesheet" />


<style type="text/css">
body {
 margin:0px;
	
}
.tieleText{font-size:14px; color:#85bd4f; font-weight:bold;}
.unitText{font-size:14px; color:#85bd4f;}
#mainFrame {
	position: absolute;
	width: 304px;
	height: 430px;
	background-image: url(images/setup2.gif);
	z-index: 1;
	left: 0px;
	top: 0px;
	display:none;
}
#PRO_title {	position:absolute;
	z-index:9;
	font-size:38px;
	color:white;
	left: 33px;
	top: 13px;
}
#G_tditle1 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 92px;
}
#G_tditle2 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 185px;
}
#G_tditle3 {
	position: absolute;
	width: 148px;
	height: 20px;
	z-index: 10;
	left: 37px;
	top: 277px;
}
#u1 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 248px;
	top: 136px;
}
#u2 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 248px;
	top: 229px;
}
#u3 {
	position: absolute;
	width: 46px;
	height: 20px;
	z-index: 10;
	left: 248px;
	top: 322px;
}

.PRO_senNameBack {width:208px; height:40px;}
.PRO_senNameBack input {
	width:208px;
	height:40px;
	line-height:28px;
	font-size:30px;
	border:0;
	color:#bfbfbf;
	background-color:transparent;
	padding-left:5px;
	padding-right:5px;text-align:center;
	
}
#v1 {
	position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 117px;
}
#v2 {
	position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 210px;
}
#v3 {	position: absolute;
	width: 208px;
	height: 40px;
	z-index: 11;
	left: 37px;
	top: 300px;
}
#PRO_submit {
	position: absolute;
	width: 100px;
	height: 41px;
	z-index: 8;
	left: 93px;
	top: 368px;
	background: url(images/pro_submit.png) no-repeat;
	line-height: 41px;
	color: white;
	text-align: center;
	font-weight: bold;
	cursor: pointer;
}
</style>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script>
var myDate = new Date();
var myDate = new Date();
var my=myDate.getFullYear();
var mm=myDate.getMonth()+1;
var md=myDate.getDate()
	
var mytime=my+"-"+mm+"-"+md+" "+myDate.toLocaleTimeString();  
$(function(){
	$(".PRO_senNameBack input").keypress(function(event) {
		var keyCode = event.which;
		if (keyCode == 46 || (keyCode >= 48 && keyCode <=57) ||keyCode == 8 ||keyCode == 127)
			return true;
		else
			return false;
		}).focus(function() {
			this.style.imeMode='disabled';
	});
	
	
	$("#s1").bind({
			focusout:function(){
				changevalue(0);
			}
	});
	$("#s2").bind({
			focusout:function(){
				changevalue(1);
			}
	});
	$('#PRO_submit').bind({
			click:function(){
				
				saveGoal()
				
			}
		});
		
	$('#mainFrame').show();
	dealData();
		
});
function saveGoal(){
	var caloriesgoal=$('#s3').val();
	var distancegoal=$('#s2').val();
	var stepgoal=$('#s1').val();
	back_ecode=$.cookie('back_ecode');
	back_ucode=$.cookie('back_ucode');
	back_scode=$.cookie('back_scode');
	var outData={ucode:back_ucode,scode:back_scode,ecode:back_ecode,source:"w",caloriesgoal:caloriesgoal,stepgoal:stepgoal,distancegoal:distancegoal,cdate:mytime};
	$.ajax({type: "POST",contentType: "application/json",dataType: "json",
			url:'res/saveprofile.php',
        	data:JSON.stringify(outData), 
        	success: function (msg) {
				
				$.cookie('back_ecode', msg.ecode);
				parent.closeGoalSetup();
				parent.updateGoalInfo(caloriesgoal,stepgoal,distancegoal);
        	}
    });
		
	
}


function dealData(){
	
	//var data=eval('(' + r + ')');  
	
	$('#s1').val(<?php echo $stepgoal; ?>)
	$('#s3').val(<?php echo $caloriesgoal; ?>)
	$('#stepwidth').val(<?php echo $stepwidth; ?>)
	if("<?php echo $unit; ?>"=="Inch"){
		$('#u2').html("miles")
		$('#rate').val("0.0000062137119223733");
	}else{
		$('#u2').html("km")
		$('#rate').val("0.00001");
	}
	changevalue(0);

}
function changevalue(m){
	if(m==0){
	var v=$('#s1').val()*$('#stepwidth').val()*$('#rate').val()
	v=Math.floor(v*1000)/1000
	$('#s2').val(v);
	}else{
	var v=$('#s2').val()/($('#stepwidth').val()*$('#rate').val())
	v=Math.ceil(v)
	$('#s1').val(v);
	}
}
</script>
</head>

<body>
<div id="mainFrame">
  <div id="PRO_title">Goal Settings</div>
  <div id="G_tditle1" class="tieleText">Daily Steps Goal:</div>
  <div id="G_tditle2" class="tieleText">Daily Distance Goal:</div>
  <div id="G_tditle3" class="tieleText">Daily Calories Goal:</div>
  <div id="u1" class="unitText">steps</div>
  <div id="u2" class="unitText">km</div>
  <div id="u3" class="unitText">cal</div>
  <div id="v1" class="PRO_senNameBack">
    <input id="s1" type="text" />
 </div>
  <div id="v2" class="PRO_senNameBack">
    <input id="s2" type="text" />
  </div>
  <div id="v3" class="PRO_senNameBack">
    <input id="s3" type="text" />
  </div>
  <div id="PRO_submit">Submit</div>
</div>
<input type="hidden" id="userid" value="<?php echo $userid; ?>" />
<input type="hidden" id="unit" value="" />
<input type="hidden" id="stepwidth" value="" />
<input type="hidden" id="rate" value="" />

</body>
</html>