<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    //Fail Connection
} else {
    if (isset($_POST['txtEditID'])) {$editID=$_POST["txtEditID"];} else {$editID="";}
    if (isset($_POST['txtproName'])) {$proName=$_POST["txtproName"];} else {$proName="";}
    
    if ($proName!=""){
        if ($editID!=""){
            $updateSql="update programnews set proName='$proName' where proID=$editID";
        } else {
            $updateSql="insert into programnews (proName,enable) values ('$proName',1)";
        }
        $result = $conn->query($updateSql);
    }
    
    if (isset($_GET['eid'])) {$eID=$_GET["eid"];}
    if ($eID!=""){
        $sql="select * from programnews where (proID=$eID)";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $edID=$row["proID"];
            $proName=$row["proName"];
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
	function enableProg(id,status){
        $("#dListUser").load("part_listProgram.php?d=" + id +"&st=" + status);
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
    <form id="frmScript" method="post" action="program.php">
			 <ul style="display: block;">
		<li><label>ชื่อรายการ : </label><input type="hidden" name="txtEditID" id="txtEditID" value="<?php echo($edID); ?>" ></input><input type="text" name="txtproName" id="txtproName" value="<?php echo($proName); ?>" class="easyui-textbox" data-options="required:true" style="width:300px"></input></li>
       <li> <label></label><button class="action blue"><span class="label">บันทึก</span></button>
<button class="action red"><span class="label">ยกเลิก</span></button>
</li>
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
	
	</section>
</body>
<script language="javascript">
$("#dListUser").load("part_listProgram.php");
</script>
</html>