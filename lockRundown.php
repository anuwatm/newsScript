<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";
require "sc.php";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

$lock=$_GET["lock"];
$ulock=$_GET["ulock"];

if ($lock!=""){
    $sql="update rundown set lockRundown=1,modifyBy='" . $_SESSION["usrName"] . "',modifyDate=now() where runID='$lock'";
    $result = $conn->query($sql);
    echo("lock Rundown ID : " . $lock);
    echo($sql);
}
if ($ulock!=""){
    $sql="update rundown set lockRundown=0,modifyBy='" . $_SESSION["usrName"] . "',modifyDate=now() where runID='$ulock'"; 
    $result = $conn->query($sql);
    echo("unLock Rundown ID : " . $ulock);
}
?>
