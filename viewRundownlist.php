<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

$fullDateNow=date('Y-m-d H:i:s');
$dateCode=date("Ymd");

if ($conn->connect_error) {
    //Fail Connection
} else {
    if (isset($_GET['id'])) {$rID=$_GET["id"];} else {$rID="";}
    
    
    $sql="select * from status where (statusID<>1 and statusID<>4) order by statusID";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $strOptionStatus=$strOptionStatus . "<option value='" .  $row["statusID"] . "'>" .  $row["statusName"] . "</option>";
        }	
    }
    if ($rID!=""){
        $sql="select * from vRundown where runID='$rID' order by runID desc";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $proName=$row["proName"];
                $dateOnAir=$row["dateOnAir"];
                $timeOnAir=$row["timeOnAir"];
                $break=$row["break"];
                $proTime=$row["programTime"];
            }
        }
    }
    $conn->close();
}
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" href="css/tablednd.css" rel="stylesheet" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/writer.css" rel="stylesheet" type="text/css" />
<link href="easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/icon.css" rel="stylesheet" type="text/css">
<link href="css/contextmenu.css" rel="stylesheet" type="text/css">
<link href="css/card.css" rel="stylesheet" type="text/css">
<link href="css/css3-buttons.css" rel="stylesheet" type="text/css">
<style>
.dragHandle   {
    cursor:move;
    width:12px;
    height:12px;
}
tr.nodrop td {
    //border-bottom: 1px solid #00bb00;
    //color: #00bb00;
}
tr.nodrag td {
    border-bottom: 1px solid #FF6600;
    color: #FF6600;
    font-weight: bold;
    
}
tr.dragItem td {
    border-bottom: 1px solid #000;
    color: #000;
    
}

</style>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.tablednd.min.js"></script>
<script language="javascript" src="easyui/jquery.easyui.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    refreshItem();
    setInterval(refreshItem, 5000);
});
function refreshItem(){
   $("#dRundownTable").load("part_viewRundown.php?id=<?php echo($rID); ?>"); 
}
function showMessage(message){
    $.messager.show({
        title:'Update Rundown',
        msg:message,
        timeout:2000,
        showType:'slide'
    });
}
function printScript(scID){
    window.open("previewScript.php?id=" + scID, "printScript", "width=860,height=600,scrollbars=yes,resizable=no");
}
          
</script>
</head>
<body>
<section class="container">
<form action="" method="post">
<br><br>
<table align='center' width='70%' border=0>
      <tr>
    <td align="right">
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="$('#dlg').dialog('open')">เพิ่มข่าว</a>
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="window.print();">พิมพ์</a>
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"  onclick="window.close();">ปิด</a>
        
    </td>
    </tr>
<tr> 
	    				<td nowrap="noWrap" valign="top">
	    					<span id="" >
	        					<strong>รายการ : </strong><?php echo($proName) ?></span><br />
	        				<span id="lblProgramOnAir" >
	        					<strong>วันที่ออก : </strong><?php echo($dateOnAir) ?></span><br />
	    					<span id="lblProgramOnAir" >
	        					<strong>เวลา : </strong><?php echo($timeOnAir) ?></span><br />
	        				<span id="lblStatus" >
	        					<strong>เวลารายการ : </strong><?php echo($proTime) ?> นาที</span>
						</td>
	  				</tr>
  	  	<tr>
	    	<td style="width: 10px"></td>
	    	<td valign="top"><hr width="90%" /></td>
	  	</tr>
    <tr>
        <td><div id="dRundownTable"></div></td>
    </tr>
</table>
        </td>
    </tr>
</form>
</section>
</body>
</html>