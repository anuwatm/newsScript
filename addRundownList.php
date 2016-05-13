<?php
require "dbConn.php";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    
} else {
    if (isset($_GET['rID'])) {$rID=$_GET["rID"];} else {$rID="";}
    if (isset($_GET['title'])) {$title=$_GET["title"];} else {$title="";}
    if (isset($_GET['time'])) {$time=$_GET["time"];} else {$time="";}

    if ($rID!="" && $title!="" && $time!=""){
        $sqlItem="select * from rundownitem where runID='$rID' order by seq desc limit 1";
        //echo($sqlItem);
        $result = $conn->query($sqlItem);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $seq=$row["seq"]+1;
            }
        } else {
            $seq=1;
        }
        $sqlItem="insert into rundownitem (runID,scID,seq,title,duration) values ('$rID',$seq,$seq,'$title','$time')";
        $result = $conn->query($sqlItem);
    }
}
?>