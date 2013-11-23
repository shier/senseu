<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$type=$obj -> type;
$num=$obj -> num;

checkuser($ucode,$scode,$ecode,$source);
$accept=0;
if($type=="accept"){$accept=1;}

//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	
$sqla ="update friendreqlist set accept=". $accept .", deal=1 where ((fromscode=? and toscode=?) or (fromscode=? and toscode=?)) and delmark=0";


$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ssss", $num,$scode, $scode,$num);
$stmta->execute();


$sqla="insert into friendlist ( sensorid,friendid,sdate) values (?, ?, ?)";

$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("sss", $scode,$num,$now);
$stmta->execute();
echo json_encode(array('status'=>200,'ecode'=>$ecode));


?>