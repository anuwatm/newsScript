<?php
checkSessionTimeOut();
?>
<script language="javascript">
        $(function(){
            $('#personProfile').tooltip({
                content: $('<div></div>'),
                showEvent: 'click',
                onUpdate: function(content){
                    content.panel({
                        width: 340,
                        border: true,
                        title: 'Person Profile',
                        href: 'person.php'
                    });
                },
                onShow: function(){
                    var t = $(this);
                    t.tooltip('tip').unbind().bind('mouseenter', function(){
                        t.tooltip('show');
                    }).bind('mouseleave', function(){
                        t.tooltip('hide');
                    });
                }
            });
        });
        function changePWD(){
            var newPWD=$("#txtID").val();
            var confirmPWD=$("#txtID").val();
            alert("test");
            if(newPWD==confirmPWD){
                $.post("pwdchg.php",{pwd:$("#txtNewPWD").val(),cpwd:$("#txtConfirmPWD").val()},function(data,status){showMessager( data);});
            } else {
                alert("Password not match!!");
            }
        }
    </script>
<div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul style="list-style-type: none;text-align: justify;font-weight:bold;word-spacing:0.5em;color:white;">
                <li style="float: left;width:300px"><img src="images/logo.png" style="float:left;margin: 10px;width:42px;height:42px;"><h2>NewsScript</h2></li>
                </ul>
            </div>
           <div class="collapse navbar-collapse navbar-menubuilder" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="writeScript.php"><img src="images/edit.png" width="25px" height="25px" /></a></li>
<?php
if ($_SESSION['rundown']==2 || $_SESSION['rundown']==1){
    echo("<li><a class='page-scroll' href='rundown.php'><img src='images/offers.png' width='25px' height='25px' /></a></li>");
}
?>
                <li><a href="#" id="personProfile"><img src="images/Person.png" width="25px" height="25px" /></a></li>
<?php 
if($_SESSION['type']=="3"){
    echo('<li><a href="manage.php" id="personProfile"><img src="images/manage.png" width="25px" height="25px" /></a></li>');    
} 
?>
                
                
                <li><a class="page-scroll" href="logout.php"><img src="images/logout.png" width="25px" height="25px" /></a></li>
            </ul>
        </div>
            <!-- /.navbar-collapse -->
        </div>