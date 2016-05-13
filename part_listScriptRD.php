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
	if (isset($_GET['k'])) {$search=$_GET["k"];} else {$search="";};
	if (isset($_GET['s'])) {$statID=$_GET["s"];} else {$statID="";};
	if (isset($_GET["p"])) {$page  = $_GET["p"]; } else {$page=1;};
	
	
	if ($search!=""){
		$cir=" where (title like '%$search%')";
	}
    if ($statID!="" && $statID!="-"){
        if ($cir!=""){
            $cir=$cir . " and (statusID=$statID)";
        } else {
            $cir=" where (statusID=$statID)";
        }
    } else {
        if ($cir!=""){
            $cir=$cir . " and (statusID<>1 and statusID<>4)";
        } else {
            $cir=" where (statusID<>1 and statusID<>4)";
        }
    }
    $sql="select * from script $cir order by scID DESC";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$imgStatus="<img src='images/status/" . $row["statusID"] . ".png' style='width:20px;height:20px' />";
			
			if ($search!=""){
				$tableList=$tableList . "<tr><td>$imgStatus</td><td><span style='cursor:hand' onclick=\"javascript:add2rundown('" . $row["scID"] . "','" . $row["duration"] . "')\">"  . str_replace($search,"<span class='keyword'>$search</span>",$row["title"]) . "</span></td></tr>";
			} else {
				$tableList=$tableList . "<tr><td>$imgStatus</td><td><span style='cursor:hand' onclick=\"javascript:add2rundown('" . $row["scID"] . "','" . $row["duration"] . "')\">" . $row["title"] . "</span></td></tr>";
			}
		}
	}

	$result = $conn->query($sql);
	$row = $result->num_rows;
	$pageCount=ceil($row /$recPage);
$conn->close();
}
?>
<link href="css/listScript.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/icon.css" rel="stylesheet" type="text/css">

<table width="90%" class="three">
<tr>
<th colspan=2>ค้นหาบทข่าว</th>
</tr>
<?php echo($tableList); ?>

</table>



