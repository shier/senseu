<?php
include "dbconnect.php";

$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

//$json_string='{"ucode":"ZFCTvSGhCzWUxXDw911paPuu0oEFUk6iJ8BK","scode":"94","ecode":"640S9VQGT5x80rsE","source":"w","stamp":"2013-8-20 17:55:52","alerttype":"fall down"}';
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;
$stamp=$obj -> stamp;
$alerttype=$obj -> alerttype;



checkuser($ucode,$scode,$ecode,$source);



$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

	
$sql="insert into alertlist (sid,alertdate,alerttype,delmark,userid) values (?,?,?,0,?)";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss",$scode,$stamp,$alerttype,$ucode);
$stmt->execute();
$stmt->close();
/*
$edate=date('Y-m-d',strtotime($stamp));

$sql="update uploadstation set umode=1 where sensorid=? and udate='" . $edate ."'";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $scode);
$stmt->execute();
*/
	
$mysqli-> close();

echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>