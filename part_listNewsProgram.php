<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
$recPage=20;

if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	if (isset($_GET['s'])) {$search=$_GET["s"];} else {$search="";};
	if (isset($_GET['pid'])) {$proID=$_GET["pid"];} else {$proID="";};
	if (isset($_GET['d'])) {$dateCode=$_GET["d"];} else {$dateCode="";};
    if (isset($_GET["p"])) {$page  = $_GET["p"]; } else {$page=1;};
	
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	if ($search!=""){
        $strCir=" and title like '%$search%'";
    }
    if ($dateCode!=""){
        $strCir=" and dateOnAir in ('$dateCode') ";
    }
	if ($strCir!=""){
        $sql="select * from vscriptprogram where (proID=$proID $strCir) order by scID desc";
	} else {
        $sql="select * from script where (proID=$proID $strCir)  order by scID desc";
	}
	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $imgStatus="<img src='images/status/" . $row["statusID"] . ".png' style='width:20px;height:20px' />";
			$process=new newsScript;
            $cssStatus=$process->setMenuTable($row["statusID"],$row["modifyBy"],$_SESSION["usrName"],$_SESSION['groupMe'],$_SESSION['approve'],$_SESSION['otherGroup']);
			
			if ($search!=""){
				$tableList=$tableList . "<tr><td>$imgStatus</td><td  class='$cssStatus'><span class='status__" . $row["statusID"] . "' style='cursor:hand' onclick=\"javascript:showContextMenu('" . $row["scID"] . "')\">" . str_replace($search,"<span class='keyword'>$search</span>",$row["title"]) . "</span><div class='desc'>" . $row["createDate"] . "</div></td></tr>";
			} else {
				$tableList=$tableList . "<tr><td>$imgStatus</td><td class='status_" . $row["statusID"] . "'><span class='$cssStatus' style='cursor:hand' onclick=\"javascript:showContextMenu('" . $row["scID"] . "')\">" . $row["title"] . "</span><div class='desc'>" . $row["createDate"] . "</div></td></tr>";
			}
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
<style>
    .desc{
        color: #555;
        font-size: 10px;
        text-align: right;
    }
</style>
<table width="90%" class="three">
<tr>
<th colspan=2>ถังรายการ</th>
</tr>
<?php echo($tableList); ?>
<tr>
<th colspan=2><?php	echo ($strPageAll); ?></th>
</tr>
</table>
<script language="javascript">
function pageDataMe(page){
	$("#dListNewsMe").load("part_listNewsMe.php?s=<?php echo($search); ?>&p=" + page);
}
$('.mnufull').contextMenu(mnuFull);
 $('.mnuPrint').contextMenu(mnuPrint);
 $('.mnuView').contextMenu(mnuView);
</script>


