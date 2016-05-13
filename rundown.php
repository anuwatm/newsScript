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
    if (isset($_GET['eid'])) {$eID=$_GET["eid"];} else {$eID="";}
    if (isset($_POST['txteditID'])) {$editID=$_POST["txteditID"];} else {$editID="";}
    if (isset($_POST['cboProgram'])) {$proID=$_POST["cboProgram"];} else {$proID="";}
    if (isset($_POST['txtDateOnAir'])) {$dateOnAir=$_POST["txtDateOnAir"];} else {$dateOnAir="";}
    if (isset($_POST['txtTimeOnAir'])) {$timeOnAir=$_POST["txtTimeOnAir"];} else {$timeOnAir="";}
    if (isset($_POST['txtBreak'])) {$break=$_POST["txtBreak"];} else {$break="";}
    if (isset($_POST['txtProDuration'])) {$proDuration=$_POST["txtProDuration"];} else {$proDuration="";}
    
    if ($dateOnAir!=""){
        $dateOnAir=date_create($dateOnAir);
        $dateOnAir=date_format($dateOnAir,"Y/m/d");
    }
    if ($proID!="" && $dateOnAir!="" && $timeOnAir!="" && $break!="" && $proDuration!=""){
        if ($editID!=""){
            $updateSql="update rundown set dateCode='$dateCode',proID=$proID,break=$break,dateOnAir='$dateOnAir',timeOnAir='$timeOnAir',programTime='$proDuration',modifyBy='" . $_SESSION["usrName"] . "',modifyDate=now() where (runID='$editID')";
        } else {
            $sql="select * from rundown where (dateCode='$dateCode') order by running desc limit 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $newID=$row["running"]+1;
                    $runID=$dateCode . right("0000" . $newID ,5);
                }
            } else {
                $newID=1;
                $runID=$dateCode . "00001";
            }
            $updateSql="insert into rundown (runID,dateCode,running,proID,break,dateOnAir,timeOnAir,programTime,statusID,modifyBy,modifyDate) values ('$runID','$dateCode','$newID',$proID,$break,'$dateOnAir','$timeOnAir','$proDuration',1,'" . $_SESSION["usrName"] . "',now())";
        }
        $result = $conn->query($updateSql);
        if ($break>0){
            $sqlItem="delete * from rundownitem where title like '==Break%'";
            $result = $conn->query($sqlItem);
            for ($x = 1; $x <= $break; $x++){
                $sqlItem="insert into rundownitem (runID,scID,seq,title) values ('$runID','b_$x',$x,'Break_$x')";
                $result = $conn->query($sqlItem);
            }
        }
    }
    
    if (isset($_GET['eid'])) {$eID=$_GET["eid"];}
    if ($eID!=""){
        $sql="select * from rundown where (runID=$eID)";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $runID=$row["runID"];
            $proID=$row["proID"];
            $dOnAir=$row["dateOnAir"];
            $tOnAir=$row["timeOnAir"];
            $break=$row["break"];
            $timeProgram=$row["programTime"];
        }
    }
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
	$(function() {
		//setInterval($("#dListUser").load("part_listRundown.php"), 5000);
	});
    function getRundown(){
        $("#dListUser").load("part_listRundown.php");
    }
        
    function manageItem(runID){
        window.open("rundownlist.php?id=" + runID, "rundown", "width=860,height=600,scrollbars=yes,resizable=yes");
    }
    function lockRundown(runID){
        $.get("lockRundown.php",{lock:runID},function(data,status){
            window.open("rundownlist.php?id=" + runID, "Preview", "width=860,height=640,scrollbars=yes,resizable=no");
        });
    }
    function viewRundown(runID){
        window.open("viewRundownlist.php?id=" + runID, "Preview", "width=860,height=640,scrollbars=yes,resizable=no");
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
    <form id="frmScript" method="post" action="rundown.php">
			 <ul style="display: block;"><input type="hidden" name="txteditID" id="txteditID" value="<?php echo($runID); ?>"></input>
		<li><label>รายการ : </label><select class="easyui-combobox" name="cboProgram" id="cboProgram" style="width:300px">
            <?php echo($strOptionProgam); ?></select></li>
        <li><label>วันที่ออก : </label><input type="text" name="txtDateOnAir" id="txtDateOnAir" value="<?php echo($dOnAir); ?>" class="easyui-datebox" data-options="required:true" style="width:300px"></input></li>
    <li><label>เวลาที่ออก : </label><input type="text" name="txtTimeOnAir" id="txtTimeOnAir" value="<?php echo($tOnAir); ?>" class="easyui-timespinner" data-options="required:true" style="width:300px"></input></li>
       <li><label>จำนวนเบรก : </label><input type="text" name="txtBreak" id="txtBreak" value="<?php echo($break); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
       <li><label>เวลารายการ : </label><input type="text" name="txtProDuration" id="txtProDuration" value="<?php echo($timeProgram); ?>" class="easyui-textbox" style="width:260px"></input> นาที</li>
<?php 
if ($_SESSION['rundown']==2){
    echo("<li> <label></label><button class='action blue'><span class='label'>บันทึก</span></button><button class='action red'><span class='label'>ยกเลิก</span></button></li>");
}
?>
        
		</ul>
</form>
</section>
			 
			 </div>
            

        </div>
<section class="card">
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
            <br />
            <br />
        </div>
    </div>
    <section>
	<script language="javascript">
$("#dListUser").load("part_listRundown.php");
    </script>
	</section>
</body>
</html>