<?php 
include "dbconnect.php";


$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
//$json_string='{"type":"act","ucode":"1GeGUBP0eFXchdYFwpOv5Vg0GmuhmHJRkuB7","scode":"39","dates":"2013-6-24","cdate":"2013-6-24 20:35:26","ecode":"XTGRdNDKGmqWrWBL","source":"w","CCID":1}';

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$type=$obj -> type;
$dates=$obj -> dates;
$cdate=$obj -> cdate;
$source=$obj -> source;

$vipmode=checkuser($ucode,$scode,$ecode,$source);

$bmr=0;
$tmpdate=explode("T", $dates); 
$moment="24:00:00";
$today=0;


$checkdate=date("Y-m-d",strtotime($tmpdate[0]));
$currentdate=date("Y-m-d",strtotime($cdate));
if($checkdate==$currentdate){
	$today=1;
	$moment=date("H:i:s",strtotime($cdate));
}
function checkWarning($scode,$ndate,$today,$moment,$mid){ //----------calc warning data, after upload, goal setting, --------------
	global $mysql_server_name;
	global $mysql_username;
	global $mysql_password;
	global $mysql_database;
	$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database);
	
	$mdate=str_replace("-","",$ndate);
	//-------get daily target--------------
	
	$ym=substr($mdate,0,6);
	$day=substr($mdate,6,8);
	$sql="select * from sensordate where yearmonth=? and day=? and sensorid=?";
	//echo "select * from sensordate where yearmonth=$ym and day=$day and sensorid=$scode";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("sss",$ym,$day ,$scode);
	$stmt->execute();
	$stmt->store_result();
	if(! $stmt->fetch()){
		//return;
	}
	
	
	$sql="select stepgoal,caloriesgoal,distancegoal,bmr from dailyvalue where sensorid=? and date=?";
	//echo "select stepgoal,caloriesgoal,distancegoal,bmr from dailyvalue where sensorid=$scode and date='$ndate'";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$ndate);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stepgoal,$caloriesgoal,$distancegoal,$bmr); 
	
	if(! $stmt->fetch()){
		return;
	}
	$stmt->close();
	$totalsteps=0;
	$totaldistance=0;
	$totalcal=0;
	$dataname=" basedata_" . $mdate ;
	$sql="select  sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance from $dataname where sensorid=? and delmark=0 and stime<?";
	//echo "select  sum(calories) as totalcal, sum(steps) as totalsteps, sum(distance) as totaldistance from $dataname where sensorid=$scode and delmark=0 and stime<'$moment'";

	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$moment);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($totalcal,$totalsteps,$totaldistance);
	$stmt->fetch();
	/*
	if(! $stmt->fetch()){
		return;
	}
	
	*/
	$stmt->close();
	//-------sensor just gather extra cal from BMR, so add in total------------

	//$totalcal=$totalcal + $bmr*$mid/288;
	$totaldistance=$totaldistance/100000;
	//echo $totalcal;
	$sql="update dailyvalue set totalcal=?, totalsteps=?, totaldistance=? where sensorid=? and date=?";
	//echo "update dailyvalue set totalcal=$totalcal, totalsteps=$totalsteps, totaldistance=$totaldistance where sensorid=$scode and date=$ndate";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("sssss", $totalcal,$totalsteps,$totaldistance,$scode,$ndate);
	$stmt->execute();
	$stmt->close();
	
	$sql="update warninginfo set delmark=1 where sensorid=? and date=?";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$ndate);
	$stmt->execute();
	$stmt->close();
	
	$sql="insert into warninginfo ( sensorid,date,catalog,title,detail) value (?,?,?,?,?)";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 	
	
	//echo "cal: $totalcal $caloriesgoal | step: $totalsteps $stepgoal | distance: $totaldistance $distancegoal";
	if($totalcal<$caloriesgoal){
		$rest=$caloriesgoal-$totalcal;
		$titleinfo='less calories';
		$cata=1;
		$restinfo='less calories ' . round($rest,1);
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totalsteps<$stepgoal){
		$rest=$stepgoal-$totalsteps;
		$restinfo='less steps ' . round($rest,0);
		$titleinfo='less steps';
		$cata=2;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	if($totaldistance<$distancegoal){
		$rest=($distancegoal-$totaldistance);
		$restinfo='less distance ' .round($rest,3);
		$titleinfo='less distance';
		$cata=3;
		$stmt->bind_param("sssss", $scode,$ndate,$cata,$titleinfo,$restinfo);
		$stmt->execute();
	}
	$stmt->close();
}
function checkNull($val){
	if (is_null($val)){
		return 0;
	}else{
		return $val;
	}
}

$reqdate=date("Y-m-d",strtotime($tmpdate[0]));
//echo $reqdate;
$datestr=str_replace("-","",$reqdate);
$yearmonth=substr($datestr,0,6);
$day=substr($datestr,6,8);
$currentNumber=timeToID($moment);

checkWarning($scode,$datestr,$today,$moment,$currentNumber);

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例
/*
$session=randomkeys(16);
$sql="update accountinfo set " . $source . "session=? where userid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();
$stmt->close();
*/
$session=$ecode;
//------------------获取当天的dailydata bmr
$sql="SELECT  bmr,stepgoal,caloriesgoal,distancegoal,stepwidth,totalcal,totaldistance, totalsteps FROM dailyvalue where sensorid=? and date=?";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $scode,$reqdate);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result( $bmr,$stepgoal,$caloriesgoal,$distancegoal,$stepwidth,$totalcal,$totaldistance, $totalsteps);
$stmt->fetch();



$timeList=array();
$valueList=array();
$modeList=array();
//$sleepmode=array();
$calList=array();
$stepList=array();
$disList=array();
$tempList=array();
$moveList=array();
$amode=array();
$smode=array();
$tmode=array();
$wakupList=array();
$outlist=array();
//----------预设act和sleep空值

for($i=0;$i<$currentNumber;$i++){
	// 0:timeStr |  1: cal | 2: step | 3: dis | 4: | wakup(1) sleep(0) | 5: cal>0 0; act=0 1 color for cal | 6: sleepmode (from sensor) | 7: move value
	// Remove BMR..
	//$outlist[$i]=idToTime($i). "|" . round($bmr/288,1) . "|0|0|0|1|0|0"; // time|temp|value|step|dist|color|sleepmode|wakeupmode
	$outlist[$i]=idToTime($i). "|0|0|0|0|1|0|0"; // time|temp|value|step|dist|color|sleepmode|wakeupmode
	
}
for($i=$currentNumber;$i<288;$i++){
	$outlist[$i]=idToTime($i). "|0.5|0|0|0|1|0|0"; // 
	
}

$havedata=1;
$sql="select * from  sensordate  where sensorid=? and yearmonth=? and day=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("sss", $scode,$yearmonth,$day);
$stmt->execute();
$stmt->store_result();
//------------return empty data when not exit current-----------------------------
if(! $stmt->fetch()){
	$havedata=0;
}
$stmt->close();

function buildTime($fh,$fm,$th,$tm){
	$fromNum=$fh*60+$fm;
	$toNum=$th*60+$tm;
	$time=rand($fromNum,$toNum);
	$hour=intval($time/60);
	$min=$time-$hour*60;
	$min=floor($min/5)*5;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}
function countTime($id){

	$time=$id*5;
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour .':' : $rndTime=$hour.':';
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}
//---------分钟转id
function timeToID($time){
	$min=explode(":", $time);
	return floor(($min[0]*60+$min[1])/5);
}
//---------id转分钟
function idToTime($id){
	$time=$id*5;
	$hour=intval($time/60);
	$min=$time-$hour*60;
	if($hour>23){$hour-=24;}
	$hour<10 ? $rndTime='0'.$hour  : $rndTime=$hour;
	$min<10 ? $rndTime=$rndTime.'0'.$min : $rndTime=$rndTime.$min;
	return  $rndTime;
}

function ctod($s){
	//global $reqdate;
	$s=substr($s,0,2) . ":" . substr($s,2,2) . ":00";	
	return $s;
}
function ttos($s){
	//global $reqdate;
	$s=substr($s,0,2) .substr($s,3,2) ;	
	return $s;
}
//----------------getdata
$dataname="basedata_" . $datestr ;
if($havedata==1){
	$sql="SELECT stime,calories,steps,distance,wakeup,move,actmode,sleepmode,tempmode,wakeup FROM $dataname where sensorid=? and delmark=0 and stime<? order by stime";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $scode,$moment);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stime,$calories,$steps,$distance,$wakeup,$move,$actmode,$sleepmode,$tempmode,$wakeup);
	while ($stmt->fetch()) {
		array_push($timeList, $stime);
		
		//$calories should not be zero. add in BMR. else ,need analyise, when is zero, return 1, else, add BMR
		$calories=checkNull($calories);
		$temp=checkNull($temp);
		$steps=checkNull($steps);
		$distance=checkNull($distance);
		$move=checkNull($move);
		if($calories>0){
			$actmode=0; //green color
		}else{
			$actmode=1; //gray color
		}
		//echo  $stime. "  ". $calories ."\n";
		//$calories=round($calories+$bmr/288,1);
		array_push($calList, $calories);
		array_push($stepList,$steps);
		array_push($disList, $distance);
		//array_push($tempList, $temp);
		array_push($modeList,$wakeup);
		array_push($moveList, $move);
		array_push($amode, $actmode);	
		array_push($smode, $sleepmode);	
		array_push($tmode, $tempmode);
	}
	$stmt->close;
}

//--------------outdata---------------------

	
for($i=0;$i<count($timeList);$i++){	
	$currentID=timeToID(substr($timeList[$i],0,2) . ":" . substr($timeList[$i],3,2));
	/*
	activity，>BMR，就选绿色;activity， <=BMR就选灰色;
	temp，15度到25度显示绿色;temp，>25度显示橙色;temp，<15度显示灰色;
	sleep是<=BMR 显示为蓝色;sleep是 >BMR 显示为灰色; 

	amode: 0:绿色，1：灰色
	sleep:1：蓝色，2：灰色
	tmode:0：绿色1：橙色2:灰色
		
	*/
	$outAmode=0;
	$outSmode=2;
		
	if(floor($calList[$i]*10)<1){
		$outAmode=1;
		$outSmode=1;
	}
	//---------睡眠状态为0，表示清醒中---------------
	if($smode[$i]==0){
		$outSmode=0;
	}
	//$outTmode=0;
	//if($tempList[$i]<15){$outTmode=2;}
	//if($tempList[$i]>25){$outTmode=1;}
	
	$outlist[$currentID]=substr($timeList[$i],0,2) . substr($timeList[$i],3,2). "|" . $calList[$i] . "|" . $stepList[$i] . "|" . $disList[$i] . "|" .  $modeList[$i] . "|" .  $amode[$i]. "|" .   $outSmode ."|" . $moveList[$i] ;
	
	// 0:timeStr |  1: cal | 2: step | 3: dis | 4: | wakup(1) sleep(0) | 5: cal>0 0; act=0 1 color for cal | 6: sleepmode (from sensor) | 7: move value
	
}
		

/*
$strsql="select count(calories) as calories from basedata_" . $datestr . " where sensorid='$scode' and delmark=0";
$result=mysql_query($strsql, $conn);
$row=mysql_fetch_array($result);
$totalCal+=floor($row['calories']*$bmr/288);
*/

//get Vip Data

$out=array('status'=>200,'caloriesGoal'=>$caloriesgoal,'disGoal'=>$distancegoal,'stepGoal'=>$stepgoal,'stepsTaken'=>$totalsteps,'calTaken'=>$totalcal,'disTaken'=>$totaldistance,'footPerStep'=>$stepwidth, 'bmr'=> $bmr,'data'=>$outlist,'ecode'=>$session,'actedata'=>"",'slpedata'=>"");

/*

UNKNOWN = 'UN'
SLEEP = 'SL'
SIT = 'SI'
WALK ='WA'
RUN = 'RU'
DRIVE = 'DR'


0x01表示DONG处于放置在桌面上；

0x02表示DONG处于佩戴在身上，睡眠中， Y轴与重力轴的夹角接近垂直，夹角在-90~-70度和70~90之间；

0x03表示 DONG处于佩戴在身上，端正坐姿，Z轴与重力轴接近垂直，夹角在-90~-70度和70~90之间;

0x04表示 DONG处于佩戴在身上， 非端正坐姿，Z轴与重力轴夹角20-70，-70~-20度；

 

0x05表示走路，判断标准为五分钟区间内步伐超过12步，且平均速度小于5.6km/h

0x06表示跑步，判断标准为五分钟区间内步伐超过12步，且平均速度大于5.6km/h（15.5dm/s）

0x07表示其它未定义MODE 

1:ST -> 9f9f9f
2:SL -> 2bc6f9
3:SI -> f39906
4:SIA -> f39906
5:WA -> 66b30c
6:RU -> 66b30c
7:UN -> e0e0e0
*/


if($vipmode==1){
	$edata=array();
	/*
	$url="http://54.245.106.189:8080/data/get_activities/";
	$ch = curl_init();
	$options = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '{"scode":"' . $scode .'","dates":"'. $dates . '"}'
	);
	// Setting curl options
	curl_setopt_array($ch, $options);
	$response = curl_exec($ch);
	
	if(curl_errno($ch)){//出错则显示错误信息
  		//print curl_error($ch);
	}else{
		$obj=json_decode($response); 
		$edata=$obj -> edata;
		for($i=0;$i<count($edata);$i++){	
			$edata[$i]->color = getColorID($edata[$i]->act);
		}
		if (is_null($edata)){$edata="";}
		$out[actedata]=$edata;	
		
	}
	curl_close($ch);
	*/
	$sql="SELECT totime,position FROM sensorstation where sensorid=? and sdate=? and delmark=0 and adjtype=0";
	$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $scode,$currentdate);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($stime,$position);
	while ($stmt->fetch()) {
		array_push($edata, array('t'=>ttos($stime),'i'=>($position-1)));
	}
	$stmt->close;
	$out[actedata]=$edata;	
	
	
}
/*
$edata=array();
$url= "http://54.245.106.189:8080/data/get_sleep_duration/";
$ch = curl_init();
$options = array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_HTTPHEADER => array('Content-type: application/json') ,
       CURLOPT_CUSTOMREQUEST => 'GET',
       CURLOPT_POSTFIELDS => '{"scode":"' . $scode .'","dates":"'. $dates . '"}'
);
// Setting curl options
curl_setopt_array($ch, $options);
$response = curl_exec($ch);
	
if(curl_errno($ch)){//出错则显示错误信息
  	//print curl_error($ch);
}else{
	$obj=json_decode($response); 
	$sleep=$obj -> sleep;
	if (is_null($sleep)){$sleep="";}
	$out[slpedata]=$sleep;			
}
curl_close($ch);
*/

$mysqli->close;	
echo json_encode($out);
?>

