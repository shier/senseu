<?php

include "dbconnect.php";

$ucode=$_REQUEST[ucode];
$scode=$_REQUEST[scode];
$ecode=$_REQUEST[ecode];
$source=$_REQUEST[source];

checkuser($ucode,$scode,$ecode,$source);

$filename= randomkeys(36) . ".jpg";//要生成的图片名字

$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例


$xmlstr =  $GLOBALS[HTTP_RAW_POST_DATA];
if(empty($xmlstr)) {
    $xmlstr = file_get_contents('php://input');
}
$jpg = $xmlstr;//得到post过来的二进制原始数据
$file = fopen("../upload/".$filename,"w");//打开文件准备写入

fwrite($file,$jpg);//写入
fclose($file);//关闭

$sql = "update sensorinfo set headimage=? where id=?"; //预处理sql语句
$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss", $filename,$scode);
$stmt->execute();
$stmt->close();

$session=randomkeys(16);

/*
$sql = "update accountinfo set " . $source . "session=? where userid=?"; 

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss", $session,$ucode);
$stmt->execute();

*/
$session=$ecode;

$mysqli->close();
echo json_encode(array('status'=>200, 'picture'=>$filename,'ecode'=>$session));	
	 
?>