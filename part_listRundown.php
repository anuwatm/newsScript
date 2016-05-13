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
	
    if ($dID!=""){
        $result = $conn->query($updateSQL);
    }
    
	if ($page!=""){
		$itemStart=($page-1)* $recPage;
	} else {
		$itemStart=0;
	}
	
	if ($search!=""){
		$sql="select * from vRundown where (proName like '%$search%') order by runID desc";
	} else {
		$sql="select * from vRundown  order by runID desc";
	}

	$result = $conn->query("$sql  LIMIT $itemStart,$recPage");
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $sqlCount="select count(*) as countNews from rundownitem where runID='" .  $row["runID"] . "'";
            $resultCount = $conn->query($sqlCount);
            if ($resultCount->num_rows > 0) {
                while($row1 = $resultCount->fetch_assoc()){
                    $countNews=$row1["countNews"]-$row["break"];
                }
            }
            if ($_SESSION['rundown']==2){
                $edit="<a href='rundown.php?eid=" .  $row["runID"] . "'><img src='images/editp.png' width='25' height='25' style='cursor:hand' border='0'></a>";
                if ($row["lockRundown"]==0){
                    $status="<img src='images/addItems.png' width='25' height='25' style='cursor:hand' border='0' onclick=\"lockRundown('" .  $row["runID"] . "');\">";
                } else {
                    $status="<img src='images/addItems.png' width='25' height='25' style='cursor:hand' border='0' onclick=\"viewRundown('" .  $row["runID"] . "');\">";
                }
            } else {
                $edit="";
                $status="<img src='images/addItems.png' width='25' height='25' style='cursor:hand' border='0' onclick=\"viewRundown('" .  $row["runID"] . "');\">";
            }
            
            $imgRundownItems="<a href='#' onclick=\"manageItem('" .  $row["runID"] . "')\"><img src='images/addItems.png'></a>";
            $tableList=$tableList . "<tr><td>$edit $status</td><td>" . $row["proName"] . "</td><td>" . $row["dateOnAir"] . "</td><td>" . $row["timeOnAir"] . "</td><td>" . $row["break"] . "</td><td>" . $row["programTime"] . " นาที</td><td>$countNews ข่าว</td></tr>";
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
<th align='center'>ชื่อรายการ</th>
<th align='center'>วันที่ออก</th>
<th align='center'>เวลาออก</th>
<th align='center'>เบรก</th>
<th align='center'>เวลารายการ</th>
<th align='center'>จำนวนข่าว</th>
</tr>
<?php echo($tableList); ?>
<tr>
<th colspan=8><?php	echo ($strPageAll); ?></th>
</tr>
</table>
<script language="javascript">
function pageDataMe(page){
	$("#dListNewsMe").load("part_listRundown.php?s=<?php echo($search); ?>&p=" + page);
}
</script>


