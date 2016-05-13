<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

$pathScript="script/";
$fullDateNow=date('Y-m-d H:i:s');
$dateCode=date("Ymd");
$fullDate=date("YmdHis");
//echo($pathScript);
if ($conn->connect_error) {
	
} else {
	if (isset($_POST['txtNewsID'])) {$scriptID=$_POST["txtNewsID"];} else {$scriptID="";}
	if (isset($_POST['txtTitle'])) {$title=$_POST["txtTitle"];} else {$title="";}
	if (isset($_POST['txtScript'])) {$script=$_POST["txtScript"];} else {$script="";}
	if (isset($_POST['statusID'])) {$status=$_POST["statusID"];} else {$status=1;}
	if (isset($_POST['cboTypeScript'])) {$typeScript=$_POST["cboTypeScript"];} else {$typeScript="0";}
	if (isset($_POST['cboTableNews'])) {$tableNews=$_POST["cboTableNews"];} else {$tableNews=$_SESSION['groupMe'];}
	if (isset($_POST['cboProgramNews'])) {$programNews=$_POST["cboProgramNews"];} else {$programNews="0";}
	if (isset($_POST['txtDateOnAir'])) {$dateOnAir=$_POST["txtDateOnAir"];} else {$dateOnAir="0";}
	if (isset($_POST['txtTimeOnAir'])) {$timeOnAir=$_POST["txtTimeOnAir"];} else {$timeOnAir="0";}
	
	//echo("scriptID=$scriptID<br>title=$title<br>script=$script<br>typeScript=$typeScript<br>tableNews=$tableNews<br>programNews=$programNews<br>dateOnAir=$dateOnAir<br>timeOnAir=$timeOnAir<br>");
	if ($title!="" && $script!=""){
		
		
        $process=new newsScript;
        $duration=$process->calcDuration($script);
		if($scriptID==""){
			$sql="select * from script where (dateCode='$dateCode') order by runID desc limit 1";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$newID=$row["runID"]+1;
					$newScriptID=$row["runID"]+1;
					$newScriptID=$dateCode . right("0000" . $newScriptID ,5);
				}
			} else {
				$newID=1;
				$newScriptID=$dateCode . "00001";
			}
			
			$sql="Insert into script (scID,runID,dateCode,title,script,duration,statusID,typeID,createBy,createDate,modifyBy,modifyDate,tblID,proID,dateOnAir,timeOnAir) values ";
			$sql=$sql ."('$newScriptID',$newID,'$dateCode','$title','$script','$duration',1,$typeScript,'" . $_SESSION["usrName"] . "','$fullDateNow','" . $_SESSION["usrName"] . "','$fullDateNow',$tableNews,$programNews,'$dateOnAir','$timeOnAir')";
			$scriptID=$newScriptID;
		} else {
			$sqlScript="select statusID from script where (scID='$scriptID')";
			$result = $conn->query($sqlScript);
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$statusOld=$row["statusID"];
				}
			} else{
                $statusOld="1";
            }
            $nc=new newsScript();
            //echo($statusOld . ":" . $nc->setStatusNow($statusOld));
            $statusID=$nc->setStatusNow($statusOld);
			$sql="update script Set title='$title',script='$script',statusID=$statusID,typeID=$typeScript,modifyBy='" . $_SESSION["usrName"] . "',modifyDate='$fullDateNow',tblID=$tableNews,proID=$programNews ,dateOnAir='$dateOnAir',timeOnAir='$timeOnAir',duration='$duration' Where (scID='$scriptID')";
		}
		writeTXTFile($pathScript . $scriptID . "_" . $statusID . ".txt",$script);
        //echo($sql);
		$result = $conn->query($sql);
	}
	
	if (isset($_GET['eid'])) {$editID=$_GET["eid"];} else {$editID=$scriptID;}
	
	if ($editID!=""){
		if ($_SESSION['approve']==1){
            $criteria=" and (statusID in (1,2,4))";  
        } else {
            $criteria=" and modifyBy like '" . $_SESSION["usrName"] . "' and (statusID in (1,2,4))";
        }
        $sql = "select * from script where (scID='$editID' $criteria)";
        //echo($sql);
		$result = $conn->query($sql);
		$row = $result->num_rows;
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$title=$row["title"];
				$script=$row["script"];
				$statusID=$row["statusID"];
				$tblID=$row["tblID"];
				$proID=$row["proID"];
				$typeID=$row["typeID"];
				$dateOnAir=$row["dateOnAir"];
				$timeOnAir=$row["timeOnAir"];
			}
		}
	}
	
	//tablenews
	$sql = "select * from tablenews  order by tblName";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row["enable"]==1){
                if ($tblID==$row["tblID"]){
                   $strOptionTable=$strOptionTable . "<option value='" .  $row["tblID"] . "' selected>" .  $row["tblName"] . "</option>"; 
                } else {
                    $strOptionTable=$strOptionTable . "<option value='" .  $row["tblID"] . "'>" .  $row["tblName"] . "</option>";
                }
            }
            
            if ($tableNews==$row["tblID"]){
				$strOptionGroup=$strOptionGroup . "<option value='" .  $row["tblID"] . "' selected>" .  $row["tblName"] . "</option>";
			} else {
				$strOptionGroup=$strOptionGroup . "<option value='" .  $row["tblID"] . "'>" .  $row["tblName"] . "</option>";
			}
		}
	}
	//programnews
	$sql="select * from programnews where enable=1 order by proName";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($proID==$row["proID"]){
				$strOptionProgam=$strOptionProgam . "<option value='" .  $row["proID"] . "' selected>" .  $row["proName"] . "</option>";
			} else {
				$strOptionProgam=$strOptionProgam . "<option value='" .  $row["proID"] . "'>" .  $row["proName"] . "</option>";
			}
		}
	}
	$sql="select * from programnews order by proName";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($proID==$row["proID"]){
				$strOptionProgamAll=$strOptionProgamAll . "<option value='" .  $row["proID"] . "' selected>" .  $row["proName"] . "</option>";
			} else {
				$strOptionProgamAll=$strOptionProgamAll . "<option value='" .  $row["proID"] . "'>" .  $row["proName"] . "</option>";
			}
		}
	}
	//typeScript
	$sql="select * from typeScript where enable=1 order by typeName";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($typeID==$row["typeID"]){
				$strOptionTypeNews=$strOptionTypeNews . "<option value='" .  $row["typeID"] . "' selected>" .  $row["typeName"] . "</option>";
			} else {
				$strOptionTypeNews=$strOptionTypeNews . "<option value='" .  $row["typeID"] . "'>" .  $row["typeName"] . "</option>";
			}
			
		}
	}
    //Employee
	$sql="select * from usr where (enable=1 and usrName<>'". $_SESSION["usrName"] ."') order by fullname";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
            $strOptionEmp=$strOptionEmp . "<option value='" .  $row["usrName"] . "'>" .  $row["fullName"] . "</option>";
        }	
    }
	
	$conn->close();
}
?>

<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News Script System</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/writer.css" rel="stylesheet" type="text/css" />
	<link href="easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
	<link href="easyui/themes/icon.css" rel="stylesheet" type="text/css">
	<link href="css/contextmenu.css" rel="stylesheet" type="text/css">
	
    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet" type="text/css" />
    <style>
        body{
            font-size:14px;
        }
    </style>
    <script language="javascript" src="js/jquery.min.js"></script>
    <script language="javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="js/jquery.ui.position.min.js"></script>
	<script type="text/javascript" src="js/contextMenu.min.js"></script>
	<script language="javascript" src="js/writer.js"></script>
	<script language="javascript">
	var intTimer=0;
	$(function() {
        $('#dlg').dialog('close');
		getAllList();
        setInterval(savetext, 10000);
        setInterval(getAllList, 30000);
        
        $('#cboGroupSearch').combobox({
            onChange: function(param){doSearchTable($('#txtSearchTable').val());}
        });
        $('#cboProgramSearch').combobox({
            onChange: function(param){doSearchProgram($('#txtSearchProgram').val());}
        });
        $('#txtDateTable').datebox({
	       onSelect: function(date){doSearchTable($('#txtSearchTable').val());}
        });
        $('#txtDateProg').datebox({
	       onSelect: function(date){doSearchProgram($('#txtSearchProgram').val());}
        });
        
	});
    
	function doSearch(value){
		//alert('You input: ' + value);
		$("#dListNewsMe").load("part_listNewsMe.php?s=" + value);
		<?php if($_SESSION["tyID"]==2){echo("enableApprove();");} else {echo("disableApprove();");} ?>
	}
    function doSearchTable(value){
		//alert("part_listNewsTable.php?t=" + $("#cboGroupSearch").val() + "&s=" + value);
        $("#dListNewsTable").load("part_listNewsTable.php?t=" + $('#cboGroupSearch').combobox('getValue') + "&s=" + value + "&d=" + $('#txtDateTable').datebox('getValue'));
		//$("#dListNewsMe").load("part_listNewsMe.php?s=" + value);
		<?php if($_SESSION["tyID"]==2){echo("enableApprove();");} else {echo("disableApprove();");} ?>
	}
    function doSearchProgram(value){
		//alert("part_listNewsProgram.php?p=" + $('#cboProgramSearch').combobox('getValue') + "&s=" + value);
        $("#dListNewsProgram").load("part_listNewsProgram.php?pid=" + $('#cboProgramSearch').combobox('getValue') + "&s=" + value + "&d=" + $('#txtDateProg').datebox('getValue'));
		//$("#dListNewsMe").load("part_listNewsMe.php?s=" + value);
		<?php if($_SESSION["tyID"]==2){echo("enableApprove();");} else {echo("disableApprove();");} ?>
	}
    function doSearchEmp(value){
		$.get("searchemp.php",{emp:$("#txtSearchEmp").val()},function(data,status){$("#txtEmpID").val(data);});
		<?php if($_SESSION["tyID"]==2){echo("enableApprove();");} else {echo("disableApprove();");} ?>
	}
    function getTranferScript(){
        $.post("tranferScript.php",{sc:$('#txtTranID').val(),emp:$('#cboEmpTranfer').combobox('getValue')},function(data,status){showMessager(data);});
        $('#dlg').dialog('close');
    }
	function doSearchWire(value){
		//alert('You input: ' + value);
		$("#dListWire").load("part_listNewsWire.php?s=" + value);
	}
	
	function showContextMenu(scID){
		$("#txtID").val(scID);
		//alert($("#txtID").val());
	}
	</script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <input type="hidden" id="txtID"></input>
    <!-- Navigation -->
    <nav id="custom-bootstrap-menu" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <?php include 'header.php'; ?>
    </nav>
    <!-- Slider -->
    <div id="home">
        <div id="slidernet"></div>
    </div>
    <!-- Page Content -->
    <div class="container-fluid">

        <div class="row">
            
			<!--Content Here !!!-->
			
<div class="easyui-layout" style="width:100%;height:560px;">
        <div id="p" data-options="region:'west'" title=" " style="width:20%;padding:15px">
		<!--***-->
		<div class="easyui-tabs" style="width:99%;height:490px">
        <div title="ตัวเอง" style="padding:5px">
		<input class="easyui-searchbox" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearch" style="width:95%" id="txtSearchMe" name="txtSearchMe"></input>
            <div id="dListNewsMe">
			
			</div>
        </div>
        <div title="โต๊ะ" style="padding:5px">
		<input class="easyui-searchbox" id="txtSearchTable" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearchTable" style="width:95%"></input><br>
		<select class="easyui-combobox" name="cboGroupSearch" id="cboGroupSearch" style="width:95%;"><?php echo($strOptionGroup); ?></select>
        <input class="easyui-datebox"  name="txtDateTable" id="txtDateTable"  data-options="formatter:newsFormater,parser:newsParser" style="width:95%;"></input>
            <div id="dListNewsTable">
			
			</div>
        </div>
        <div title="รายการ" style="padding:5px">
		<input class="easyui-searchbox" id="txtSearchProgram" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearchProgram" style="width:95%"></input>
    <select class="easyui-combobox" name="cboProgramSearch" id="cboProgramSearch" style="width:95%;" ><?php echo($strOptionProgamAll); ?></select>
            <input class="easyui-datebox"  name="txtDateProg" id="txtDateProg" data-options="formatter:newsFormater,parser:newsParser" style="width:95%;"></input>
            <div id="dListNewsProgram">
			
			</div>
        </div>
		<div title="Wire" style="padding:20px">
		<input class="easyui-searchbox" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearchWire" style="width:95%"></input>
            <div id="dListWire">
			
			</div>
        </div>
    </div>
		<!--***-->
            
        </div>
        <div data-options="region:'center'" title=" " class="script1">
		<!--<div class="easyui-panel" style="padding:5px;">
			<a href="#" class="easyui-linkbutton" data-options="plain:true">Save</a>
		</div>--><br>
<form id="frmScript" method="post" action="writescript.php" data-options="novalidate:true">
		<ul>
		<li><label>หัวข้อข่าว : </label><input type="hidden" name="txtNewsID" id="txtNewsID" value="<?php echo($editID); ?>"><input type="hidden" name="txtStatusID" id="txtStatusID" value="<?php echo($statusID); ?>"></input><input type="text" name="txtTitle" id="txtTitle" value="<?php echo($title); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
		<li><label>ประเภท : </label><select class="easyui-combobox" name="cboTypeScript" id="cboTypeScript" style="width:300px;"><option value="">-</option><?php echo($strOptionTypeNews); ?></select></li>
		<li><label>โต๊ะข่าว: </label><select class="easyui-combobox" name="cboTableNews" id="cboTableNews" style="width:300px;" data-options="required:true"><option value=""></option><?php echo($strOptionTable); ?></select></li>
		<li><label>รายการ : </label><select class="easyui-combobox" name="cboProgramNews" id="cboProgramNews" style="width:300px;" data-options="required:true"><option value=""></option><?php echo($strOptionProgam); ?></select></li>
		<li><label>วันที่ออก : </label><input class="easyui-datebox"  name="txtDateOnAir" id="txtDateOnAir" value="<?php echo($dateOnAir); ?>" data-options="formatter:newsFormater,parser:newsParser" style="width:300px" data-options="required:true"></input></li>
		<li><label>เวลาที่ออก : </label><input type="text" name="txtTimeOnAir" id="txtTimeOnAir" value="<?php echo($timeOnAir); ?>" class="easyui-timespinner" style="width:300px"></input></li>
		<!--<li><label>เวลาบทข่าว : </label><span id='sDuration'></span></li>-->
		<li style="width:95%"><label>เนื้อหา : </label><textarea id="txtScript" name="txtScript" style="width:90%;height:380px"><?php echo($script); ?></textarea></li>
		</ul>
        </div>
</div>
</form>
			<!--Content Here !!!-->

        </div>
        </div>

        </div>
    </div>


<div id="dlg" class="easyui-dialog" title="Toolbar and Buttons" style="width:400px;height:200px;padding:10px"
            data-options="
                iconCls: 'icon-save',
                buttons: [{
                    text:'Tranfer',
                    iconCls:'icon-ok',
                    handler:function(){
                        getTranferScript();
                    }
                },{
                    text:'Cancel',
                    handler:function(){
                        $('#dlg').dialog('close');
                    }
                }]
            ">
    <label>บทข่าว : </label><span id="dTitleTran"></span><br><input type="hidden" id="txtTranID" name="txtTranID">
        ชื่อคนที่ต้องการโอน :<select class="easyui-combobox" name="cboEmpTranfer" id="cboEmpTranfer" style="width:95%;"><option value=""></option><?php echo($strOptionEmp); ?></select><input type="hidden" id="txtEmpID" name="txtEmpID">
    </div>

<script language="javascript">
<?php if($_SESSION['approve']==1){echo("enableApprove();\n");} else {echo("setTimeout(function(){disableApprove();}, 500);\n");} ?>
<?php if($_SESSION['groupMe']==1){echo("setTimeout(function(){disableSave();}, 500);\n");} ?>
<?php if($_SESSION['approve']==1){echo("enableApprove();\n");} else {echo("setTimeout(function(){disableApprove();}, 1000);\n");} ?>
$('.mnufull').contextMenu(mnuFull);
$('.mnuPrint').contextMenu(mnuPrint);
$('.mnuView').contextMenu(mnuView);
</script>

</body>
</html>