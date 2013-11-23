<?php 
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$rcode=$obj -> rcode;

checkuser($ucode,$scode,$ecode,$source);



//--------------check ucode---------------------

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

	
$sqla ="update friendlist set delmark=1 where (sensorid=? and friendid=?) or (sensorid=? and friendid=?)";
//echo 	"update friendlist set delmark=1 where (sensorid=$scode and friendid=$rcode) or (sensorid=$rcode and friendid=$scode)";
$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ssss", $scode,$rcode,$rcode,$scode);
$stmta->execute();

$sqla ="update friendreqlist set delmark=1 where (toscode=? and fromscode=?) or (fromscode=? and toscode=?)";
//echo "update friendreqlist set delmark=1 where (sensorid=$scode and friendid=$rcode) or (sensorid=$rcode and friendid=$scode)";
$stmta = $mysqli->stmt_init();
$stmta = $mysqli->prepare($sqla); //将sql添加到mysqli进行预处
$stmta->bind_param("ssss", $scode,$rcode,$rcode,$scode);
$stmta->execute();


echo json_encode(array('status'=>200));


?>