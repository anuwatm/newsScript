<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
	//title:$("#txtTitle").val(),Script:$("#txtScript").val(),TypeScript:$("#cboTypeScript").val(),TableNews:$("#cboTableNews").val(),ProgramNews:$("#cboProgramNews").val(),DateOnAir:$("#txtDateOnAir").val(),TimeOnAir:$("#txtTimeOnAir").val()
} else {
	if (isset($_POST['uid'])) {$uid=$_POST["uid"];} else {$uid="";}
	if (isset($_POST['st'])) {$status=$_POST["st"];} else {$status="";}
	
	if ($uid!="" && $status!=""){
        $sql="update usr Set enable=$status Where (usrName='$uid')";
        $result = $conn->query($sql);
        echo("Enable/Disable User Complete !!");
	}
    
	$conn->close();
}
?>
