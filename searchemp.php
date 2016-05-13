<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

checkSessionTimeOut();

$fullDateNow=date('Y-m-d H:i:s');
if (isset($_GET["emp"])) {$search=$_GET["emp"];} else {$search="";}
if ($search!=""){
    $sql="select * from usr where (empID like '%$search%' )";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tranEmp=$row["usrName"];
        }
    }
    echo($tranEmp);
}
?>
