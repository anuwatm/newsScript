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
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/writer.css" rel="stylesheet" type="text/css" />
<link href="easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="easyui/themes/icon.css" rel="stylesheet" type="text/css">
<link href="css/contextmenu.css" rel="stylesheet" type="text/css">
<link href="css/card.css" rel="stylesheet" type="text/css">
<link href="css/css3-buttons.css" rel="stylesheet" type="text/css">
<style>
.durationTime {
    text-align: right;
    text-indent: 5px;
    color: darkblue;
}
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
ul {
    padding: 1; 
    margin: 0;
    list-style-type: none;
}
ul li {
    width: 450px;
    float: left;
}
label{
    width:80px;
    text-align: center;
}
.desc{
    color: #555;
    font-size: 10px;
    text-align: left;
}
</style>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.tablednd.min.js"></script>
<script language="javascript" src="easyui/jquery.easyui.min.js"></script>
<script language="javascript">
var seqID;
$(document).ready(function() {
    $('#dlg').dialog('close');
	$('#dlgAdd').dialog('close');
	$("#table-1").tableDnD();
    $("#dRundownTable").load("part_manageRundown.php?id=<?php echo($rID); ?>");
});
function refreshTime(){
    $("#dRundownTable").load("part_manageRundown.php?id=<?php echo($rID); ?>");
}
function doSearch(value){
    $("#dSearch").load("part_listScriptRD.php?s=" + $('#cboStatus').combobox('getValue') + "&k=" + value);
}
function add2rundown(scID,duration){
    $("#dRundownTable").load("part_manageRundown.php?seq=" + seqID + "&id=<?php echo($rID); ?>&nID="+ scID + "&ti=" + duration);
    //alert(duration);
    $('#dlg').dialog('close')
}
function delScript(scID){
    $("#dRundownTable").load("part_manageRundown.php?id=<?php echo($rID); ?>&delID="+ scID);
}
function showMessage(message){
    $.messager.show({
        title:'Update Rundown',
        msg:message,
        timeout:2000,
        showType:'slide'
    });
}
function unLockRundown(){
    $.get("lockRundown.php",{ulock:<?php echo($rID); ?>},function(data,status){showMessage(data);window.close();});
    
}
function printScript(scID){
    window.open("previewScript.php?id=" + scID, "printScript", "width=860,height=600,scrollbars=yes,resizable=no");
}
function findScript(scID){
    seqID=scID;
    $('#dlg').dialog('open');
}
function clearData(){
    $("#txtTitleNews").textbox('clear');
    $("#txtTimeNews").textbox('clear');
    $("#dRundownTable").load("part_manageRundown.php?id=<?php echo($rID); ?>");
    $('#dlgAdd').dialog('close');
}
function addRundownList(){
    $.get("addRundownList.php",{rID:'<?php echo($rID); ?>',title:$("#txtTitleNews").val(),time:$("#txtTimeNews").val()},function(data,status){clearData();});
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
        <!--<a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="$('#dlg').dialog('open')">เพิ่มข่าว</a>-->
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="clearData();$('#dlgAdd').dialog('open')">เพิ่มข่าว</a>
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="window.print();">พิมพ์</a>
        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"  onclick="unLockRundown();">ปิด</a>
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


    <div class="result"></div>
    
    <div id="dlg" class="easyui-dialog" title="เพิ่มบทข่าวลง Rundown" style="width:600px;height:450px;padding:4px"
            data-options="
                iconCls: 'icon-save',
                toolbar: '#dlg-toolbar',
                buttons: '#dlg-buttons'
            ">
    <div id="dSearch"></div>
    </div>
    <div id="dlg-toolbar" style="padding:2px 0">
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td style="padding-left:2px">
                    <select class="easyui-combobox" name="cboStatus" id="cboStatus" style="width:100px">
                        <option value="">-</option>
                        <?php echo($strOptionStatus); ?>
                    </select>
                </td>
                <td style="text-align:right;padding-right:2px">
                    <label nowrap>ค้นหาข่าว :</label>
                    <input class="easyui-searchbox" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearch" style="width:250px"></input>
                </td>
            </tr>
        </table>
    </div>
    <div id="dlg-buttons">
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:alert('save')">บันทึก</a>-->
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="javascript:$('#dlg').dialog('close')">ยกเลิก</a>
    </div>
</form>
</section>
<div id="dlgAdd" class="easyui-dialog" title="เพิ่มข่าวเข้า Rundown" style="width:520px;height:160px;padding:10px"
            data-options="
                
                buttons: [{
                    text:'เพิ่มข่าว',
                    iconCls:'icon-ok',
                    handler:function(){
                        addRundownList();
                    }
                },{
                    text:'ยกเลิก',
                    handler:function(){
                        $('#dlgAdd').dialog('close')
                    }
                }]
            ">
        <ul>
            <li><label>หัวข้อข่าว : </label><input id="txtTitleNews" name="txtTitleNews" class="easyui-textbox" style="width:80%;"></li>
            <li><label>เวลาข่าว : </label><input id="txtTimeNews" name="txtTimeNews" class="easyui-textbox" style="width:40%;"> นาที</li>
        </ul>
    </div>
</body>
<script language="javascript">
    /*
function toSeconds(time_str) {
    // Extract hours, minutes and seconds
    var parts = time_str.split(':');
    // compute  and return total seconds
    return parts[0] * 3600 + parts[1] * 60 + parts[2];
}

var a = "10:22:57"
var b = "10:30:00"
$process=
var difference = Math.abs(toSeconds(a) - toSeconds(b));

// format time differnece
var result = [
    Math.floor(difference / 3600), // an hour has 3600 seconds
    Math.floor((difference % 3600) / 60), // a minute has 60 seconds
    difference % 60
];
// 0 padding and concatation
result = result.map(function(v) {
    return v < 10 ? '0' + v : v;
}).join(':');
//alert(result);
*/
</script>
</html>