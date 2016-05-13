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
	if (isset($_GET["p"])) {$page  = $_GET["p"]; } else {$page=1;};
	
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	
	if ($search!=""){
		$sql="select * from script where (title like '%$search%') order by scID desc";
	} else {
		$sql="select * from script  order by scID desc";
	}
	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$imgStatus="<img src='images/status/" . $row["statusID"] . ".png' style='width:20px;height:20px' />";
            $print="<img src='images/printer.png' style='width:20px;height:20px' />";
            $nc=new newsScript();
            $status1=$nc->printScriptByStatus($row["scID"],1);
			$status2=$nc->printScriptByStatus($row["scID"],2);
			$status3=$nc->printScriptByStatus($row["scID"],3);
			$status4=$nc->printScriptByStatus($row["scID"],4);
			$status5=$nc->printScriptByStatus($row["scID"],5);
			if ($search!=""){
				$tableList=$tableList . "<tr><td>$imgStatus $print</td><td><span class='status_" . $row["statusID"] . "' style='cursor:hand' onclick=\"javascript:showContextMenu('" . $row["scID"] . "')\">" . str_replace($search,"<span class='keyword'>$search</span>",$row["title"]) . "</span></td><td>$status1</td><td>$status2</td><td>$status3</td><td>$status4</td><td>$status5</td></tr>";
			} else {
				$tableList=$tableList . "<tr><td>$imgStatus $print</td><td class='status_" . $row["statusID"] . "'><span class='$cssStatus' style='cursor:hand' onclick=\"javascript:showContextMenu('" . $row["scID"] . "')\">" . $row["title"] . "</span></td><td>$status1</td><td>$status2</td><td>$status3</td><td>$status4</td><td>$status5</td></tr>";
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

<table width="90%" class="three">
<tr>
<th></th>
<th>หัวข้อข่าว</th>
<th align="center"><img src="images/status/1.png" style="width:25px;height:25px"></th>
<th align="center"><img src="images/status/2.png" style="width:25px;height:25px"></th>
<th><img src="images/status/3.png" style="width:25px;height:25px"></th>
<th><img src="images/status/4.png" style="width:25px;height:25px"></th>
<th><img src="images/status/5.png" style="width:25px;height:25px"></th>
</tr>
<?php echo($tableList); ?>
<tr>
<th></th>
<th colspan=7><?php	echo ($strPageAll); ?></th>

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


