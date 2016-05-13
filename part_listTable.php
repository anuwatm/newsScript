<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
$recPage=20;


if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	if (isset($_GET['s'])) {$search=$_GET["s"];} else {$search="";};
	if (isset($_GET["p"])) {$page  = $_GET["p"]; } else {$page=1;};
	if (isset($_GET["d"])) {$dID  = $_GET["d"]; } else {$dID="";};
	if (isset($_GET["st"])) {$status  = $_GET["st"]; } else {$status="";};
	
    if ($dID!=""){
        $updateSQL="Update tablenews set enable=$status Where tblID=$dID";
        $result = $conn->query($updateSQL);
    }
    
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	
	if ($search!=""){
		$sql="select * from tablenews where (tblName like '%$search%') order by tblName";
	} else {
		$sql="select * from tablenews  order by tblName";
	}

	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tablename=$row["tblName"];
            $tableID=$row["tblID"];
            switch($row["enable"]) {
				case "0":
					$enableIcon="<img src='images/disable.png' width='25' height='25' border='0' style='cursor:hand' onclick='javascript:enableTable(\"$tableID\",\"1\")'>";
					break;
				case "1":
					$enableIcon="<img src='images/enable.png' width='25' height='25' border='0' style='cursor:hand' onclick='javascript:enableTable(\"$tableID\",\"0\")'>";
					break;
			}
			$edit="<a href='table.php?eid=$tableID'><img src='images/editp.png' width='25' height='25' style='cursor:hand' border='0'></a>";
			$lastLogin=$row["lastLogin"];
			$tableList=$tableList . "<tr><td align='center'>$enableIcon  $edit</td><td>$tablename</td></tr>";
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

<table class="three">
<tr>
<th></th>
<th align='center'>ชื่อโต๊ะ</th>
</tr>
<?php echo($tableList); ?>
<tr>
<th colspan=8><?php	echo ($strPageAll); ?></th>
</tr>
</table>
<script language="javascript">
function pageDataMe(page){
	$("#dListNewsMe").load("part_listTable.php?s=<?php echo($search); ?>&p=" + page);
}
</script>


