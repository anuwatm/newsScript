<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

checkSessionTimeOut();

$fullDateNow=date('Y-m-d H:i:s');
if (isset($_POST["sc"])) {$scID=$_POST["sc"];} else {$scID="";}
if (isset($_POST["emp"])) {$empID=$_POST["emp"];} else {$empID="";}
if ($empID!="" && $scID!=""){
    $dateCode=date("Ymd");
    $sql="select * from script where (dateCode='$dateCode') order by runID desc limit 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $newID=$row["runID"]+1;
            $newScriptID=$row["runID"]+1;
            $newScriptID=$dateCode . right("0000" . $newScriptID ,5);
        }
    } else {
        $newID=1;
        $newScriptID=$dateCode . "00001";
    }
    
    $sql="select * from script where (scID='$scID')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $title=$row["title"];
            $duration=$row["duration"];
            $script=$row["script"];
            $typeID=$row["typeID"];
            $createBy=$row["createBy"];
            $createDate=$row["createDate"];
            $referTo=$scID;
            $tblID=$row["tblID"];
            $proID=$row["proID"];
            $dateOnAir=$row["dateOnAir"];
            $timeOnAir=$row["timeOnAir"];
        }
        $TranferSql="Insert into script (scID,runID,dateCode,title,script,duration,statusID,typeID,createBy,createDate,modifyBy,modifyDate,tblID,proID,dateOnAir,timeOnAir) values ";
        $TranferSql=$TranferSql ."('$newScriptID',$newID,'$dateCode','$title','$script','$duration',1,$typeID,'$createBy','$createDate','$empID','$fullDateNow',$tblID,$proID,'$dateOnAir','$timeOnAir')";
        $result = $conn->query($TranferSql);
        echo("Tranfer Script complete !!");
    }
}
?>
