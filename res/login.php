<?php
include "dbconnect.php";



$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];

$obj=json_decode($json_string); 

$email=$obj -> email;
$password=$obj -> password;

$source=$obj -> source;

$ucode="";
$scode="";
$nickname="";


//--------check database--------------
$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例

$sql = "select userid,salt from  accountinfo where email=?"; //预处理sql语句
//echo  "select userid,salt from  accountinfo where email=$email";
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($ucode,$salt);  
if(! $stmt->fetch()){
	echo json_encode(array('status'=>'101'));
	exit;
}
$stmt->close();
//echo "\n pass:$password, sale:$salt";
$password = convertpass($salt,$password);

$sql = "select * from  accountinfo where email=? and password=?"; //预处理sql语句
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("ss", $email,$password);
$stmt->execute();
$stmt->store_result();

if(! $stmt->fetch()){
	echo json_encode(array('status'=>'101'));
	exit;
}
$stmt->close();

$ecode=randomkeys(16);


$sql="select id,nickname,seedkey from sensorinfo where userid=? ";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处
$stmt->bind_param("s", $ucode);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($scode,$nickname,$kcode);  
if(! $stmt->fetch()){
	echo json_encode(array('status'=>'202','userInfo'=>array('ucode'=>$ucode,'use'=>$ecode)));
	exit;
}
$stmt->close();

saveSession($ucode,$scode,$ecode,$source);

echo json_encode(array('status'=>'200','userInfo'=>array('ucode'=>$ucode,'scode'=>$scode,'nickname'=>$nickname,'ecode'=>$ecode,'kcode'=>$kcode)));


?>