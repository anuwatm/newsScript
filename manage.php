<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	

$conn->close();
}
?>
<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News Script System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/themes/default/layout.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/layout.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/icon.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/default/easyui.css" rel="Stylesheet" type="text/css" />
    <link href="css/shop-item.css" rel="stylesheet" type="text/css" />
    <style>
        body{
            font-size:10pt;
        }
        .inputWidth{
            font-size:10pt;
            width:50%;
        }
        #wowwidget a{
            text-decoration: none;
            padding: .2em 1em;
            
        }
        #managepanel {
            position: absolute;
            top: 60%;
            left: 50%;
            width: 500px;
            height: 500px;
            margin-left: -250px;
            margin-top: -50px;
        }
    </style>
    <script language="javascript" src="js/jquery.js"></script>
    <script language="javascript" src="js/jquery.easyui.min.js"></script>
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
    <div class="container">

        <div class="row" style="text-align: center;">
            
            <p>
                <div class="wowwidget">
            <div class="col-md-2"></div>
			<div class="col-md-2"><a href="user.php"><img src="images/Persons.png" style="width:125px;height:125px"><br><h2>ผู้ใช้งาน</h2></a></div>
            <div class="col-md-2"><a href="table.php"><img src="images/Group.png" style="width:125px;height:125px"><br><h2>โต๊ะข่าว</h2></a></div>
            <div class="col-md-2"><a href="program.php"><img src="images/programtv.png" style="width:125px;height:125px"><br><h2>รายการ</h2></a></div>
            <div class="col-md-2"><a href="scLog.php"><img src="images/script.png" style="width:125px;height:125px"><br><h2>บทข่าว</h2></a></div>
            <div class="col-md-2"></div>
            
                    </div>
            </p>

        </div>
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
    <script src="js/jquery.js"></script>

    </form>
</body>
</html>