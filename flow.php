<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
$pathScript="script/";
$fullDateNow=date('Y-m-d H:i:s');

if ($conn->connect_error) {

} else {
	if (isset($_POST['cpID'])) {$completeID=$_POST["cpID"];} else {$completeID="";}
	if (isset($_POST['apID'])) {$approveID=$_POST["apID"];} else {$approveID="";}
	if (isset($_POST['title'])) {$title=$_POST["title"];} else {$title="";}
	if (isset($_POST['Script'])) {$script=$_POST["Script"];} else {$script="";}
	if (isset($_POST['TypeScript'])) {$TypeScript=$_POST["TypeScript"];} else {$TypeScript="";}
	if (isset($_POST['TableNews'])) {$TableNews=$_POST["TableNews"];} else {$TableNews="";}
	if (isset($_POST['ProgramNews'])) {$ProgramNews=$_POST["ProgramNews"];} else {$ProgramNews="";}
	if (isset($_POST['DateOnAir'])) {$DateOnAir=$_POST["DateOnAir"];} else {$DateOnAir="";}
	if (isset($_POST['TimeOnAir'])) {$TimeOnAir=$_POST["TimeOnAir"];} else {$TimeOnAir="";}
	if (isset($_POST['status'])) {$status=$_POST["status"];} else {$status="";}

    $fullDateNow=date('Y-m-d H:i:s');
    $nc=new newsScript();
    $duration=$nc->calcDuration($script);
    $statusID="";
	if ($completeID!=""){
        switch($status){
            case 1:
                $status=2;
                break;
            case 4:
                $status=5;
                break;
        }
        writeTXTFile($pathScript . $completeID . "_$status.txt",$script);
        $sql="update script Set title='$title',script='$script',statusID=$status,typeID=$TypeScript,modifyBy='" . $_SESSION["usrName"] . "',modifyDate=now(),tblID=$TableNews,proID=$ProgramNews ,dateOnAir='$DateOnAir',timeOnAir='$TimeOnAir',duration='$duration' Where (scID='$completeID')";
	}
	
	if ($approveID!=""){
        writeTXTFile($pathScript . $approveID . "_3.txt",$script);
        $sql="update script Set title='$title',script='$script',statusID=3,typeID=$TypeScript,modifyBy='" . $_SESSION["usrName"] . "',modifyDate=now(),tblID=$TableNews,proID=$ProgramNews ,dateOnAir='$DateOnAir',timeOnAir='$TimeOnAir',duration='$duration' Where (scID='$approveID')";
	}
    
    if ($approveID!="" || $completeID!=""){
        $result = $conn->query($sql);
    }
    
	$conn->close();
}
?>
