<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);



//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql ="SELECT b.id,b.nickname,b.headimage from friendlist as a, sensorinfo as b where ((b.id=a.friendid and a.sensorid=?) or (b.id=a.sensorid and a.friendid=?)) and a.delmark=0";
	
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $scode, $scode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nickname,$head);
	
$mname=array();
	
while ($stmt->fetch()) {
	$sqla ="SELECT caloriesgoal,totalcal,sleepgoal,totalsleep FROM dailyvalue WHERE sensorid=? order by date desc limit 0,1";
	
	$stmta = $mysqli->stmt_init();
	$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
	$stmta->bind_param("s", $id);
	$stmta->execute();
	$stmta->store_result();
	$stmta->bind_result($caloriesgoal, $totalcal,$sleepgoal,$totalsleep);
	$stmta->fetch();
	$peract=$totalcal/$caloriesgoal;
	$perslp=$totalsleep/$sleepgoal;
	if($peract>1){$peract=1;}
	if($perslp>1){$perslp=1;}
	array_push($mname,array('nickname'=>$nickname,'head'=>$head,'scode'=>$id,'peract'=>$peract,'perslp'=>$perslp));	
}

echo json_encode(array('status'=>200,'friendlist'=>$mname,'ecode'=>$ecode));


?>