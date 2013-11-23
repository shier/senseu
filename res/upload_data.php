<?php
include "dbconnect.php";
//include "warning.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

//$json_string='{"ucode":"f2026d8c-d99c-4535-2a7b-7ad18c28c4b5","scode":"1","data":[{"stamp":"2013-05-31 13:02","rawdata":[{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30},{"x":0,"y":100,"z":-30}]}],"type":"raw"}';
$conn=mysql_connect($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
mysql_select_db($mysql_database,$conn);
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$data=$obj -> data;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$dateid=0;
$oldDate="";
$type="base";
$beginTime=date("Y-m-d H:i:s");

checkuser($ucode,$scode,$ecode,$source);
/*
$nowTime=date("Y-m-d H:i:s");
$difftime=strtotime($nowTime)-strtotime($beginTime);

// echo ("check user time cost" . $difftime . "\n");
$beginTime=$nowTime;
*/
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

function checkValueLib($ndate){
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	global $conn;
	global $scode;
	global $type;
	
	$sql="SELECT id from uploadstation where sensorid=$scode and udate='$ndate'";
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		$sql="insert into uploadstation ( sensorid,udate,umode) value ($scode,'$ndate',1)";
	}else{
		$sql="update uploadstation set umode=1 where sensorid=$scode and udate='$ndate'";
	}
	$result=mysql_query($sql,$conn); 
	
	$mdate=str_replace("-","",$ndate);
	$libname="basedata_" . $mdate ;

	$ym=substr($mdate,0,6);
	$day= substr($mdate,6,8);
	$sql="select * from sensordate where yearmonth=$ym and day=$day and sensorid=$scode";
	$result=mysql_query($sql,$conn); 
	$row=mysql_num_rows($result);
	if($row==0){
		$sql="insert into sensordate ( yearmonth,day,sensorid,type) value ($ym,$day,$scode,'$type')";
		$result=mysql_query($sql,$conn); 
	}
}


$beginDate=explode(" ", $data[0] ->stamp . ":00");
$bdate=date('Y-m-d',strtotime($beginDate[0]));;

$endDate=explode(" ", $data[count($data)-1] ->stamp . ":00");
$edate=date('Y-m-d',strtotime($endDate[0]));;

while($bdate <= $edate){
	checkValueLib($bdate);
	$bdate=date('Y-m-d',strtotime("$bdate 1 day"));
}

$statusList=array();
$dateList=array();
$rndstring=randomkeys(6);

$sql="insert into tempupload (sdate,stime,calories,steps,distance,move,sleepmode,angle,maxspeed,minspeed,averagespeed,detectedposition,sensorid,rndstring) values (?,?,?,?,?,?,?,?,?,?,?,?,$scode,'$rndstring')";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);

for($i=0;$i<count($data);$i++){
	$ndate=explode(" ", $data[$i] -> stamp);
	$datestr=str_replace("-","",$ndate[0]);
	//checkValueLib($datestr);
	//-------------save time
	$sourcedate=$data[$i] -> stamp;
	$sourcedate= $sourcedate. ":00";
	$ntime=$ndate[1]. ":00";
	$libname="basedata_" .$datestr;
	
	$calories= $data[$i] -> calories;
	$steps= $data[$i] -> steps;
	$distance= $data[$i] -> distance;
	$temp= $data[$i] -> temp;
	$move= $data[$i] -> move;
	$angle= $data[$i] -> angle;
	$maxspeed= $data[$i] -> maxspeed;
	$minspeed= $data[$i] -> minspeed;
	$averagespeed= $data[$i] -> averagespeed;
	$detectedposition= $data[$i] -> detectedposition;

	$sleepmode= $data[$i] -> sleepmode;
	

	$stmt->bind_param("ssssssssssss",$datestr,$ntime,$calories,$steps,$distance,$move,$sleepmode,$angle,$maxspeed,$minspeed,$averagespeed,$detectedposition);
	$stmt->execute();
	$result=mysql_query($sql,$conn); 
	
	
	$addDate=1;
	for($j=0;$j<count($dateList);$j++){
		if($dateList[$j][ldate]==$ndate[0]){
			$addDate=0;
		}
	}
	if($addDate==1){
		array_push($dateList,  array('ldate'=>$ndate[0] ,'sdate'=>$datestr));
	}
}
$stmt->close();
$mysqli-> close();	

//-------------dedupe-----------------

for($i=0;$i<count($dateList);$i++){

	$sql="update uploadstation set umode=1 where sensorid=$scode and udate='" . $dateList[$i][ldate] ."'";
	$result=mysql_query($sql,$conn); 
	

	$sql="delete from basedata_" . $dateList[$i][sdate] . " where sensorid=$scode and stime in (select stime from tempupload where sensorid=$scode and sdate='" .$dateList[$i][sdate] ."' and rndstring='" . $rndstring . "')";
	// echo $sql;
	$result=mysql_query($sql,$conn); 
	
	

	$sql="insert into basedata_" . $dateList[$i][sdate] . " (stime, calories, steps, distance, move, sleepmode, actmode, tempmode, wakeup, sleepbelongs, sensorid, angle, maxspeed, minspeed, averagespeed, detectedposition) select stime, calories, steps, distance, move, sleepmode, actmode, tempmode, wakeup, sleepbelongs, sensorid, angle, maxspeed, minspeed, averagespeed, detectedposition from tempupload where sensorid=$scode and sdate='" .$dateList[$i][sdate] ."' and rndstring='" . $rndstring . "'";
	
	$result=mysql_query($sql,$conn); 
	
	$sql="delete from tempupload where rndstring='" . $rndstring . "'";
	$result=mysql_query($sql,$conn); 
	
	
}


$nowTime=date("Y-m-d H:i:s");
$difftime=strtotime($nowTime)-strtotime($beginTime);

$beginTime=$nowTime;

//---------------------------get sensor mode-------------------------------------



$sql="select updated from sensorinfo where id=$scode";
$result=mysql_query($sql,$conn); 
$row=mysql_fetch_array($result);
$updated=$row['updated'];

$sensorinfo="";

if ($updated==1){
	
	$sql ="SELECT * FROM totalinfo  WHERE  sensorid=$scode order by date desc limit 0,1";
	$result=mysql_query($sql,$conn); 
	$row=mysql_fetch_array($result);
	$vname=array();
	$value=array();
	array_push($vname,"station");
	array_push($value,$row['station']);
	array_push($vname,"connected");
	array_push($value,$row['connected']);
	array_push($vname,"power");
	array_push($value,$row['power']);
	array_push($vname,"nickname");
	array_push($value,$row['nickname']);
	array_push($vname,"headimage");
	array_push($value,$row['headimage']);
	array_push($vname,"dob");
	array_push($value,$row['dob']);
	array_push($vname,"unit");
	array_push($value,$row['unit']);
	array_push($vname,"gender");
	array_push($value,$row['gender']);
	array_push($vname,"age");
	array_push($value,$row['age']);
	array_push($vname,"height");
	array_push($value,$row['height']);
	array_push($vname,"weight");
	array_push($value,$row['weight']);
	array_push($vname,"stepgoal");
	array_push($value,$row['stepgoal']);
	array_push($vname,"caloriesgoal");
	array_push($value,$row['caloriesgoal']);
	array_push($vname,"stepwidth");
	array_push($value,$row['stepwidth']);
	array_push($vname,"distancegoal");
	array_push($value,$row['distancegoal']);
	array_push($vname,"runningwidth");
	array_push($value,$row['runningwidth']);
	array_push($vname,"bmi");
	array_push($value,$row['bmi']);	
	array_push($vname,"bmr");
	array_push($value,$row['bmr']);	
	array_push($vname,"sleepgoal");
	array_push($value,$row['sleepgoal']);	
	array_push($vname,"detailid");
	array_push($value,$row['detailid']);	
	array_push($vname,"usertype");
	array_push($value,$row['vipmode']);	
	$sensorinfo=array_combine($vname,$value);

}

//$ecode=randomkeys(16);
//saveSession($ucode,$scode,$ecode,$source);

mysql_close($conn);  

	
echo json_encode(array('status'=>200,'updated'=>$updated,'scode'=>$scode,'sdata'=>$sensorinfo,'ecode'=>$ecode));
?>