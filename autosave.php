<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

checkSessionTimeOut();

$fullDateNow=date('Y-m-d H:i:s');
if (isset($_POST["textScript"])) {$script=$_POST["textScript"];} else {$script="";}
if ($script!=""){
    $nc=new newsScript();
    $duration=$nc->calcDuration($script);
    writeTXTFile("autosave/" . $_SESSION["usrName"] . ".txt",$script);
    echo($script);
}
?>
