<?php

include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$fid=$obj-> fid;
$source=$obj -> source;
checkuser($ucode,$scode,$ecode,$source);

$now=date("Y-m-d H:i:s");
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql = "select id from friendreqlist where fromscode=? and toscode=? and delmark=0";

$stmt = $mysqli->stmt_init();
	$stmt = $mysqli->prepare($sql); 
	$stmt->bind_param("ss", $scode,$fid);
	$stmt->execute();
	$stmt->store_result();
	if($stmt->fetch()){
		echo json_encode(array('status'=>'205'));
		exit;
	}

	

$sql = "insert into friendreqlist (fromucode,fromscode,toscode,rdate) values (?,?,?,?)"; //预处理sql语句

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ssss", $ucode,$scode,$fid,$now);
$stmt->execute();

$mysqli->close();

echo json_encode(array('status'=>200));	
	 
?>