<?php
require "dbConn.php";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");


if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	$strUsername="";
	$strPassword="";
	if (isset($_POST["usr"] ) || isset($_POST["pwd"] ) ){
		$strUsername=$_POST["usr"];
		$strPassword=$_POST["pwd"];
		$sql = "SELECT * FROM usr Where (usrName='" . $strUsername  . "' and pwd='" . encrypt_decrypt('encrypt',$strPassword) ."')";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				session_start();
				$_SESSION["empID"]=$row["empID"];
				$_SESSION["usrName"]=$row["usrName"];
				$_SESSION["fullName"]=$row["fullName"];
				$_SESSION['timeout']=time();
                $_SESSION['groupMe']=$row["groupMe"];
                $_SESSION['groupTable']=$row["groupTable"];
                $_SESSION['approve']=$row["Approve"];
                $_SESSION['otherGroup']=$row["otherGroup"];
                $_SESSION['type']=$row["typeID"];
                $_SESSION['rundown']=$row["rundown"];
                
                
				$sql="Update usr Set IPAddress='" . $_SERVER['REMOTE_ADDR'] . "',lastLogin=now() Where (empID='" . $row["empID"]  . "')";
				mysqli_query($conn, $sql);
				header("Location: writeScript.php");
				die();
			}
		}
	}

$conn->close();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="css/login.css" rel="stylesheet" />

<script src="js/jquery.min.js"></script>
<script language="javascript">
</script>
</head>
<body>
<section class="container">
<div class="login">
<form action="index.php" method="post">
    <fieldset>
      <H1><img src="images/logo.png" style="float:left;margin: 2 5 10px 10px;width:35px;height:35px;" />เข้าระบบ</H1>
	  <p><input type="text" id="usr" name="usr" autocomplete="off" placeholder="กรุณากรอก Username"</p>
	  <p><input type="Password" id="pwd" name="pwd" autocomplete="off"  placeholder="กรุณากรอก Password"></p>
      <span id="ansresult">&nbsp;</span>
	  
      <div class="buttons"><input type="submit" value="Login" name="Login" class="google-button google-button-blue" id="Login"><div>
			 
    </fieldset>
</form>
</div>
</section>

</body>
</html>