<?php
require "dbConn.php";
require "sc.php";


if (isset($_POST['sc'])) {$script=$_POST["sc"];} else {$script="";}

if($script!=""){
    $process=new newsScript;
    $duration=$process->calcDuration($script);
    echo("Duration : $duration");
} else {
    echo("Duration : $duration");
}
?>
