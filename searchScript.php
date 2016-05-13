<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

checkSessionTimeOut();

$fullDateNow=date('Y-m-d H:i:s');
if (isset($_GET["sc"])) {$search=$_GET["sc"];} else {$search="";}
if ($search!=""){
    $sql="select * from script where (scID like '%$search%' )";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $title=$row["title"];
        }
    }
    echo($title);
}
?>
