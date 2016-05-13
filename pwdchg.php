<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    
} else {
	if (isset($_POST['pwd'])) {$pwd=$_POST["pwd"];} else {$pwd="";}
	if (isset($_POST['cpwd'])) {$cpwd=$_POST["cpwd"];} else {$cpwd="";}
	
	if ($pwd!="" && $pwd==$cpwd ){
        $password=encrypt_decrypt('encrypt', $pwd);
        $sql="update usr Set pwd='$password' Where (usrName='" . $_SESSION["usrName"] . "')";
        $result = $conn->query($sql);
        echo("Change Password Complete !!");
	}
    
	$conn->close();
}
?>
