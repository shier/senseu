<?php
include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$power=$obj -> power;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$source=$obj -> source;

checkuser($ucode,$scode,$ecode,$source);
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); 

$sql="update sensorlist set power=? where userid=? and sensorid=?";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss",$power,$ucode,$scode);
$stmt->execute();
$stmt->close();
$mysqli->close();
echo json_encode(array('status'=>200,'ecode'=>$ecode));
?>
