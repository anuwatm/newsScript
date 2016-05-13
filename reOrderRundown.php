<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

$result = $_POST["order"];
$runID=$_POST["runID"];
$result=str_replace("%5B","[",$result);
$result=str_replace("%5D","]",$result);
$result=str_replace("table-3[]=","",$result);

$order=explode("&",$result);
for($i=0;$i<=count($order);$i++){
   if($order[$i]!=""){
       $sqlOrder ="Update rundownitem set seq=" . ($i+1) . " where (runID='$runID' and scID='" . $order[$i] . "')";
       $result = $conn->query($sqlOrder);
   } 
}
echo("Update Rundown OK !!!");
?>
