<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");



if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	if (isset($_GET['id'])) {$sID=$_GET["id"];} else {$sID="";}
	if($sID!=""){
        $sql="select * from vScript where (scID='$sID')";
        $result = $conn->query($sql);
        $row = $result->num_rows;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $title=$row["title"];
                $script=$row["script"];
                $statusID=$row["statusID"];
                $statusName=$row["statusName"];
                $tblID=$row["tblID"];
                $tblName=$row["tblName"];
                $proID=$row["proID"];
                $proName=$row["proName"];
                $typeID=$row["typeID"];
                $dateOnAir=$row["dateOnAir"];
                $timeOnAir=$row["timeOnAir"];
                $cBy=$row["cFullname"];
                $cDate=$row["createDate"];
                $mBy=$row["mFullname"];
                $mDate=$row["modifyDate"];
                $onAirDate=$row["dateOnAir"];
                $onAirTime=$row["timeOnAir"];
                $process=new newsScript;
                $duration=$process->calcDuration($script);
                $content=$process->getScriptOnly(str_replace("<p>", "^n<p>",$script));
                $pContent=explode("|",$content);
                $table="";
                foreach($pContent as $val){
                    $pc=explode("]",$val);
                    if (count($pc)>1){
                        $table=$table . "<tr><td class='command-start'>" . $pc[0] . "]</td><td class='Script'>" . str_replace("^n", "<br>",$pc[1]) . "</td></tr>"; 
                    } else {
                        if (strpos($pc[0],"[",0)>0){
                            $table=$table . "<tr><tdclass='command-start'>" . $pc[0] . "]</td><td></td></tr>";
                        } else {
                            if($pc[0]!="^n"){
                                $table=$table . "<tr><td></td><td>" . str_replace("^n", "<br>",$pc[0]) . "</td></tr>";
                            }
                            
                        }
                        
                    }
                    
                }
            }
        }
    }
	
$conn->close();
}
?>
<html>
<head>
	<title>
		<?php echo($title) ?>	</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/print.css" />
    <link rel="stylesheet" type="text/css" href="css/css3-buttons.css" />
    <script language="javascript">
	    function fullScreen() {
	        window.focus();
	    }
    </script>
</head>
<body bottommargin="0" leftmargin="0" rightmargin="0" topmargin="0"  onload="fullScreen();">
    
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  	<tr>
	    	<td style="width: 10px"></td>
	    	<td valign="top">
	    		<table id="header" width="685" border="0" cellspacing="0" cellpadding="0">
	  				<tr> 
	    				<td width="100%" nowrap="noWrap" valign="top"> 
	    					<input type="button" value="พิมพ์" name="Login" class="google-button google-button-blue"  onclick="window.print();">
                            <input type="button" value="ปิด" name="Login" class="google-button google-button-red" onclick="window.close();"><br />
	        				<span id="lblTitle" ><strong>ข่าว : </strong><?php echo($title) ?></span><br />
	        				<span id="lblTime" ><strong>เวลา : </strong><?php echo($duration) ?> นาที</span><br />
	        				<span id="lblModify" ><strong>แก้ไขครั้งสุดท้าย : </strong><?php echo("$mBy [$mDate]") ?></span>
						</td>
	    				<td nowrap="noWrap" valign="top">
	        				<span id="lblProgram" >
	        					<strong>โต๊ะข่าว : </strong><?php echo($tblName) ?></span><br />
	    					<span id="" >
	        					<strong>รายการ : </strong><?php echo($proName) ?></span><br />
	        				<span id="lblProgramOnAir" >
	        					<strong>วันที่ออก : </strong><?php echo($onAirDate) ?></span><br />
	    					<span id="lblProgramOnAir" >
	        					<strong>เวลา : </strong><?php echo($onAirTime) ?></span><br />
	        				<span id="lblStatus" >
	        					<strong>สถานะ : </strong><?php echo($statusName) ?></span>
						</td>
	  				</tr>
			  </table>    
			</td>
	  	</tr>
	  	<tr>
	    	<td style="width: 10px"></td>
	    	<td valign="top"><hr width="90%" /></td>
	  	</tr>
	  	<tr>
	    	<td style="width: 10px"></td>
	    	<td valign="top">
	        	<div>
					<table cellspacing="2" cellpadding="5"  align="Left" border="1" id="GridView" width="685" >
                        <?php echo($table); ?>
				    </table>
				</div>         
			</td>
		</tr>
	</table>
</form>
<pre>	
	
</pre>
</body>
</html>


