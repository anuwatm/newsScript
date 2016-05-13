<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
$recPage= 20;


if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	if (isset($_GET['s'])) {$search=$_GET["s"];} else {$search="";};
	if (isset($_GET["p"])) {$page  = $_GET["p"]; } else {$page=1;};
	if (isset($_GET["d"])) {$dID  = $_GET["d"]; } else {$dID="";};
	if (isset($_GET["st"])) {$status  = $_GET["st"]; } else {$status="";};
	
    if ($dID!="" && $status!=""){
        $updateSQL="Update usr set enable=$status Where usrName='$dID'";
        $result = $conn->query($updateSQL);
    }
    
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	
	if ($search!=""){
		$sql="select * from usr where (fullName like '%$search%' or usrName like '%$search%' or empID like '%$search%') order by fullName";
	} else {
		$sql="select * from usr  order by fullName";
	}

	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$username=str_replace($search,"<span class='keyword'>$search</span>",$row["usrName"]);
			$fullname=str_replace($search,"<span class='keyword'>$search</span>",$row["fullName"]);
			$groupMe=readPermission($row["groupMe"]);
			$groupTable=readPermission($row["groupTable"]);
            $rundown=readPermission($row["rundown"]);
            $Approve=$row["Approve"];
            $groupOther=$row["otherGroup"];
			switch($row["enable"]) {
				case "0":
					$enableIcon="<img src='images/person_bw.png' width='25' height='25' border='0' style='cursor:hand' onclick='javascript:setStstus(\"$username\",\"1\")'>";
					break;
				case "1":
					$enableIcon="<img src='images/person_col.png' width='25' height='25' border='0' style='cursor:hand' onclick='javascript:setStstus(\"$username\",\"0\")'>";
					break;
			}
			$edit="<a href='user.php?eid=$username'><img src='images/editp.png' width='25' height='25' style='cursor:hand' border='0'></a>";
			$lastLogin=$row["lastLogin"];
			$tableList=$tableList . "<tr><td align='center'>$enableIcon  $edit</td><td>$username</td><td>$fullname</td><td>$groupMe</td><td>$groupTable</td><td>" . permitOther($groupOther) . "</td><td>" . permitOther($Approve) . "</td><td>" . $rundown . "</td><td>$lastLogin</td></tr>";
		}
	}

	$result = $conn->query($sql);
	$row = $result->num_rows;
	$pageCount=ceil($row /$recPage);
	for ($pageNum = 1; $pageNum <= (double)$pageCount; $pageNum++) {
		if ($pageNum==$page) {
			$strPageAll=$strPageAll . "  <span class='pagination'><span class='context-menu-1'>" . $pageNum  . "</span></span>";
		} else {
			$strPageAll=$strPageAll . " <span  class='pagination'><a href='#' onclick='pageDataMe($pageNum);'>" . $pageNum  . "</a></span>";
		}
	}

	
	
$conn->close();
}
?>
<link href="css/listScript.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/icon.css" rel="stylesheet" type="text/css">
<script language="javascript">

</script>
<table width="90%" class="three">
<tr>
<th></th>
<th align='center'>Username</th>
<th align='center'>ชื่อ - นามสกุล</th>
<th align='center'>ถังข่าวตัวเอง</th>
<th align='center'>ถังข่าวโต๊ะ</th>
<th align='center'>ถังข่าวโต๊ะอื่น</th>
<th align='center'>Approve</th>
<th align='center'>Rundown</th>
<th align='center'>Last Login</th>
</tr>
<?php echo($tableList); ?>
<tr>
<th colspan=9><?php	echo ($strPageAll); ?></th>
</tr>
</table>
<script language="javascript">
function pageDataMe(page){
    $("#dListUser").load("part_listUser.php?s=<?php echo($search); ?>&p=" + page);
}
/*
function enableUser(){
    
}
*/
/*$('.mnufull').contextMenu(mnuFull);
 $('.mnuPrint').contextMenu(mnuPrint);
 $('.mnuView').contextMenu(mnuView);
 */
</script>


