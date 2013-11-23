<?php

include "dbconnect.php";
$json_string=$GLOBALS['HTTP_RAW_POST_DATA'];
$obj=json_decode($json_string); 

$ucode=$obj -> ucode;
$scode=$obj -> scode;
$ecode=$obj -> ecode;
$keyword='%'.strtolower($obj-> keyword).'%';
$source=$obj -> source;
checkuser($ucode,$scode,$ecode,$source);


$mysqli = new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //创建mysqli实例


$sql = "select b.nickname,b.id,b.headimage from accountinfo as a, sensorinfo as b where a.userid=b.userid and  (lcase(b.nickname) like ? or lcase(a.email) like ?)"; //预处理sql语句

//echo "select b.nickname,b.id,b.headimage from accountinfo as a, sensorinfo as b where a.userid=b.userid and  (lcase(b.nickname) like '$keyword' or lcase(a.email) like '$keyword')";

$stmt = $mysqli->stmt_init();
$stmt = $mysqli->prepare($sql); //将sql添加到mysqli进行预处理
$stmt->bind_param("ss", $keyword,$keyword);

$stmt->execute();
$stmt->store_result();
$stmt->bind_result($nickname,$id,$headimge);  
$itemList=array();    
while ($stmt->fetch()) {
	if($id != $scode){ //-----donot search self-----------
		array_push($itemList,array('nickname'=>$nickname,'id'=>$id,'headimage'=>$headimge));
	}
}
$mysqli->close();

echo json_encode(array('status'=>200, 'friList'=>$itemList));	
	 
?>