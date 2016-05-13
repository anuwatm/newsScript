<?php

header("Content-type:application/json; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");      
header("Cache-Control: post-check=0, pre-check=0", false);

$servername = "10.1.75.91";
$username = "003710";
$password = "352131711";
$dbname = "newsScript";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

function jsonRemoveUnicodeSequences($struct) {
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}

if ($conn->connect_error) {
	
} else {
	
	$sql = "select * from tablenews where enable=1";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$json_data[]=array("tblID"=>$row["tblID"],"tblName"=>$row["tblName"],);
		}
	}
	
	$json=json_encode($json_data);
	echo(jsonRemoveUnicodeSequences($json_data));
	$conn->close();
}
?>