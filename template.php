<?php
require "dbConn.php";

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
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="css/themes/default/layout.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/layout.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/icon.css" rel="stylesheet" type="text/css" />
    <link href="css/themes/default/easyui.css" rel="Stylesheet" type="text/css" />
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
    </style>
    <script language="javascript" src="js/jquery.js"></script>
    <script language="javascript" src="js/jquery.easyui.min.js"></script>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <form id="form2" runat="server">
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
            
			Content Here !!!

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
            <!-- Projects Row -->
            <!-- /.row -->
            <!-- Projects Row -->
            <br />
            <br />
        </div>
    </div>
    <section>
	
	</section>
    <!-- /footer section end-->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->

    </form>
</body>
</html>