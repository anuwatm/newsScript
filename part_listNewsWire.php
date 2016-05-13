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
	
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	
	if ($search!=""){
		$sql="select * from wire where (title like '%$search%') order by dateStamp desc";
	} else {
		$sql="select * from wire order by dateStamp desc";
	}

	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($search!=""){
				$tableList=$tableList . "<tr><td></td><td><a href='" . $row["link"] . "' target='wire'>" . str_replace($search,"<span class='keyword'>$search</span>",$row["title"]) . "</a></td></tr>";
			} else {
				$tableList=$tableList . "<tr><td></td><td><a href='" . $row["link"] . "' target='wire'>" . $row["title"] . "</a></td></tr>";
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
			$strPageAll=$strPageAll . " <span  class='pagination'><a href='#' onclick='pageDataWire($pageNum);'>" . $pageNum  . "</a></span>";
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
<th colspan=2>RSS Feed</th>
</tr>
<?php echo($tableList); ?>
<tr>
<th colspan=2><?php	echo ($strPageAll); ?></th>
</tr>
</table>
<script language="javascript">
function pageDataWire(page){
	$("#dListWire").load("part_listNewsWire.php?s=<?php echo($search); ?>&p=" + page);
}
</script>


