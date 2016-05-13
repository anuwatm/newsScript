<?php
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

function setPermit($value){
    $option="<option value=''></option>";
    if ($value=="1"){$option="$option<option value='1' selected>อ่าน</option>";} else{$option="$option<option value='1'>อ่าน</option>";}
    if ($value=="2"){$option="$option<option value='2' selected>อ่าน/เขียน</option>";} else{$option="$option<option value='2'>อ่าน/เขียน</option>";}
    return $option;
}
if ($conn->connect_error) {
    //Fail Connection
} else {
    if (isset($_POST['txtEditID'])) {$editID=$_POST["txtEditID"];} else {$editID="";}
    if (isset($_POST['txtEmpID'])) {$empID=$_POST["txtEmpID"];} else {$empID="";}
    if (isset($_POST['txtFullname'])) {$fullName=$_POST["txtFullname"];} else {$fullName="";}
    if (isset($_POST['txtUsername'])) {$userName=$_POST["txtUsername"];} else {$userName="";}
    if (isset($_POST['txtPassword'])) {$pwd=$_POST["txtPassword"];} else {$pwd="";}
    if (isset($_POST['cboTableNews'])) {$tableNews=$_POST["cboTableNews"];} else {$tableNews="";}
    if (isset($_POST['cboProgramNews'])) {$programNews=$_POST["cboProgramNews"];} else {$programNews="";}
    if (isset($_POST['cboTypeUser'])) {$typeUser=$_POST["cboTypeUser"];} else {$typeUser="";}
    if (isset($_POST['cboPermitMe'])) {$permitMe=$_POST["cboPermitMe"];} else {$permitMe="";}
    if (isset($_POST['cboPermitTable'])) {$permitTable=$_POST["cboPermitTable"];} else {$permitTable="";}
    if (isset($_POST['cboRundown'])) {$permitRundown=$_POST["cboRundown"];} else {$permitRundown="";}
    if (isset($_POST['chkApprove'])) {$approveNews=$_POST["chkApprove"];} else {$approveNews=0;}
    if (isset($_POST['chkOther'])) {$permitOther=$_POST["chkOther"];} else {$permitOther=0;}
    
    if ($empID!=""){
        $password=encrypt_decrypt('encrypt', $pwd);
        if ($editID!=""){
            $updateSql="update usr set empID='$empID',fullName='$fullName',usrName='$userName',pwd='$password',typeID=$typeUser,tblID=$tableNews,proID=$programNews,groupMe=$permitMe,groupTable=$permitTable,Approve=$approveNews,otherGroup=$permitOther,rundown=$permitRundown where uid=$editID";
        } else {
            $updateSql="insert into usr (empID,fullName,usrName,pwd,createDate,enable,typeID,tblID,proID,groupMe,groupTable,Approve,otherGroup,rundown) values ('$empID','$fullName','$userName','$password',now(),1,$typeUser,$tableNews,$programNews,$permitMe,$permitTable,$approveNews,$permitOther,$permitRundown)";
        }
        //echo($updateSql);
        $result = $conn->query($updateSql);
    }
    
    if (isset($_GET['eid'])) {$eID=$_GET["eid"];}
    if ($eID!=""){
        $sql="select * from usr where (usrName='$eID')";
        //echo($sql);
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $edID=$row["uid"];
            $empid=$row["empID"];
            $fullName=$row["fullName"];
            $userName=$row["usrName"];
            $pwd=encrypt_decrypt('decrypt',$row["pwd"]);
            $typeID=$row["typeID"];
            $tblID=$row["tblID"];
            $proID=$row["proID"];
            $permitMe=$row["groupMe"];
            $permitTable=$row["groupTable"];
            $approveNews=$row["Approve"];
            $permitOther=$row["otherGroup"];
            $permitRundown=$row["rundown"];
        }
    }
    
	//tablenews
	$sql = "select * from tablenews where enable=1";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($tblID==$row["tblID"]){
				$strOptionTable=$strOptionTable . "<option value='" .  $row["tblID"] . "' selected>" .  $row["tblName"] . "</option>";
			} else {
				$strOptionTable=$strOptionTable . "<option value='" .  $row["tblID"] . "'>" .  $row["tblName"] . "</option>";
			}
		}
	}
	//Type User
	$sql = "select * from typeuser where enable=1";
	$result = $conn->query($sql);
	$row = $result->num_rows;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($typeID==$row["tyID"]){
				$strOptionType=$strOptionType . "<option value='" .  $row["tyID"] . "' selected>" .  $row["tyName"] . "</option>";
			} else {
				$strOptionType=$strOptionType . "<option value='" .  $row["tyID"] . "'>" .  $row["tyName"] . "</option>";
			}
		}
	}
	//programnews
	$sql="select * from programnews where enable=1";
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
    $nc=new newsScript();
    $optionTableMe=$nc->setPermit($permitMe);
    $optionTableNews=$nc->setPermit($permitTable);
    $optionRundown=$nc->setPermit($permitRundown);
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
	<link href="css/card.css" rel="stylesheet" type="text/css">
	<link href="css/css3-buttons.css" rel="stylesheet" type="text/css">
	
    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet" type="text/css" />
    <style>
        body{
            font-size:10pt;
        }
        .inputWidth{
            font-size:10pt;
            width:50%;
        }
        ul li{
            display: block;
        }
        label{
            width:90px;
            text-align: right;
        }
        
    </style>
    <script language="javascript" src="js/jquery.min.js"></script>
    <script language="javascript" src="easyui/jquery.easyui.min.js"></script>
	<script language="javascript">
	/*
	$(function() {
		$("#dListUser").load("part_listUser.php");
	}
	*/
        function setStstus(uID,status){
            $("#dListUser").load("part_listUser.php?d=" + uID +"&st=" + status);
        }
        function searchUser(){
            $("#dListUser").load("part_listUser.php?s=<?php echo($search); ?>&p=" + page);
        }
        function doSearchUser(value,name){
            $("#dListUser").load("part_listUser.php?s=" + value);
        }
	</script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
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
             <div class="col-md-3"></div>
			 <div class="col-md-6">
<section class="card">
    <form id="frmScript" method="post" action="user.php">
			 <ul style="display: block;"><!--	uid,empID,fullName,usrName,pwd,createDate,enable,tblID,proID,groupMe,groupTable,Approve,otherGroup-->
		<li style="display: block;"><label>รหัสพนักงาน : </label><input type="hidden" name="txtEditID" id="txtEditID" value="<?php echo($edID); ?>"></input><input type="text" name="txtEmpID" id="txtEmpID" value="<?php echo($empid); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
		<li><label>ชื่อ - นามสกุล : </label><input type="text" name="txtFullname" id="txtFullname" value="<?php echo($fullName); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
        <li><label>Username : </label><input type="text" name="txtUsername" id="txtUsername" value="<?php echo($userName); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
		<li><label>Password : </label><input type="password" name="txtPassword" id="txtPassword" value="<?php echo($pwd); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
		<li><label>โต๊ะข่าว : </label><select class="easyui-combobox" name="cboTableNews" id="cboTableNews" style="width:300px;"><option value=""></option><?php echo($strOptionTable); ?></select></li>
		<li><label>รายการ : </label><select class="easyui-combobox" name="cboProgramNews" style="width:300px;"><option value=""></option><?php echo($strOptionProgam); ?></select></li>
		
		<li><label>ประเภท : </label><select class="easyui-combobox" name="cboTypeUser" style="width:300px;"><option value=""></option><?php echo($strOptionType); ?></select></li>
		<li><label>ถังตัวเอง : </label><select style="width:100px" class="easyui-combobox" name="cboPermitMe"><?php echo($optionTableMe) ?></select><label>ถังโต๊ะ : </label><select class="easyui-combobox" name="cboPermitTable" style="width:110px;"><?php echo($optionTableNews) ?></select></li>
<li><label>Rundown : </label><select class="easyui-combobox" name="cboRundown" style="width:300px;"><option value=""></option><?php echo($optionRundown); ?></select></li>
		<li> <label></label><input type="checkbox" name="chkApprove" value="1" <?php if($approveNews==1){echo(" checked");}; ?>></input>Approve <input type="checkbox" name="chkOther" value="1" <?php if($permitOther==1){echo(" checked");}; ?>>โต๊ะอื่น</li>
        <li> <label></label><button class="action blue"><span class="label">บันทึก</span></button>
<button class="action red"><span class="label">ยกเลิก</span></button>
</li>
		</ul>
</form>
</section>
			 
			 </div>




        </div>
<section class="card">
<input class="easyui-searchbox" id="txtSearchTable" data-options="prompt:'กรุณาใส่คำค้น',searcher:doSearchUser" style="width:300px"></input>    
          <div id="dListUser">bb</div>      
            </section>
        </div>



            <div class="col-md-3">
                <div class="sidebar">
                    <div class="wowwidget">
                        
&nbsp;</div>
                </div>
            </div>
            <div class="col-md-9">
                
&nbsp;</div>

            <div class="page-header">
                <div class="container">
                </div>
            </div>
            <!-- Projects Row -->
            <!-- /.row -->
            <!-- Projects Row -->
            <br />
            <br />
        </div>
    </div>
    <section>
	
	</section>
</body>
<script language="javascript">
$("#dListUser").load("part_listUser.php");
</script>
</html>