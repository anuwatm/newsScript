<?php
header('Content-Type: text/html; charset=utf-8');
require "dbConn.php";
require "sc.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");
$recPage=20;

if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	if (isset($_GET['id'])) {$rID=$_GET["id"];} else {$rID="";};
	if (isset($_GET['nID'])) {$newsID=$_GET["nID"];} else {$newsID="";};
	if (isset($_GET['delID'])) {$delID=$_GET["delID"];} else {$delID="";};
	if (isset($_GET['ti'])) {$duration=$_GET["ti"];} else {$duration="";};
	if (isset($_GET['seq'])) {$seq=$_GET["seq"];} else {$seq="";};
	
    if ($rID!="" && $newsID!="" && $seq!=""){
        $sqlItem="update rundownitem set scID='$newsID',duration='$duration' where (runID='$rID' and scID='$seq') ";
        $result = $conn->query($sqlItem);
    }
    if ($rID!="" && $delID!=""){
        $sqlItem="delete from rundownitem where (runID='$rID' and scID='$delID')";
        //echo($sqlItem);
        $result = $conn->query($sqlItem);
    }
	if ($rID!=""){
        $sql="select * from vRundown where runID='$rID' order by runID desc";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $proName=$row["proName"];
                $dateOnAir=$row["dateOnAir"];
                $timeOnAir=$row["timeOnAir"];
                $break=$row["break"];
                $proTime=$row["programTime"];
            }
            $sqlItem="select * from vRundownItem where (runID='$rID') order by seq";
            $result = $conn->query($sqlItem);
            $table="";
            if ($result->num_rows > 0){
                $totalDuration=0;
                while($row = $result->fetch_assoc()){
                    $bin="<img src='images/bin2.png' style='cursor:hand' onclick=\"delScript('" . $row["scID"] . "')\">";
                    $process=new newsScript;
                    if (("".$row["scriptTime"])!=""){
                        $durationNews=$row["scriptTime"];
                        $timeDuration=$process->toSeconds($row["scriptTime"]);
                    } else {
                        $durationNews=$row["duration"];
                        $timeDuration=$process->toSeconds($row["duration"]);
                    }
                    
                    $totalDuration=$totalDuration+$timeDuration;
                    $showTotalTime=$process->set2Digit(floor($totalDuration / 3600)) . "." .$process->set2Digit(floor(($totalDuration / 60) % 60)) . "." . $process->set2Digit($totalDuration % 60, -2);

                    if (strlen($row["scID"])<5){
                        $script="<img src='images/new.png' width='25' height='25' style='cursor:hand' onclick=\"findScript('" . $row["scID"] . "')\">";
                        $titleNews=$row["title"];
                        $print="";
                    } else {
                        $script="<img src='images/new.png' width='25' height='25' style='cursor:hand' onclick=\"findScript('" . $row["scID"] . "')\">";
                        $titleNews=$row["title"] . '<div class="desc">' . $row["scriptHeader"]  . '</div>';
                        $print="<a href='#' title='" . $row["scriptHeader"] . "' class='easyui-tooltip'><img src='images/printer.png' width='25' height='25' style='cursor:hand' border='0' onclick=\"printScript('" .  $row["scID"] . "')\"></a>";
                    }
                    
                    
                    if (strpos($row["title"],"reak_")>0) {
                        $dragMode="nodrag";
                        
                        $table=$table . "<tr id=" . $row["scID"] . " class='$dragMode'><td></td><td nowrap>" . $row["title"] . "</td><td><input type='hidden' name='txtNewsID' value=" . $row["scID"] . "/></td><td  class='durationTime'>$showTotalTime</td><td></td><td></td></tr>";
                    } else {
                        $dragMode="dragHandle";
                        
                        $table=$table . "<tr id='" . $row["scID"] . "'  class='dragItem'><td><img src='images/sort.png' class='$dragMode'></td><td nowrap>$titleNews</td><td class='durationTime'><input type='hidden' name='txtNewsID' value='" . $row["scID"] . "'/>$durationNews</td><td  class='durationTime'>$showTotalTime</td><td></td><td nowrap align='center'>$script $print $bin</td></tr>";
                    }

                }
            }
        }
    }
$conn->close();
}
?>
  <table id="table-3" cellspacing="1" cellpadding="3" width="600px" >
    <tr class="nodrop">
        <th><input name="txtRundown" id="txtRundown" type="hidden" value="<?php echo($rID) ?>"></th>
        <th>ข่าว</th>
        <th style="text-align: right;">เวลา</th>
        <th  style="text-align: right;">เวลารวม</th>
        <th nowrap align="center"><!--เวลารวม--></th>
        <th></th>
    </tr>
    <?php echo($table); ?>
    </table> 
<script>
 $('#table-3').tableDnD({
            onDragStart: function(table, row) {
                $(table).parent().find('.result').text('');
            },
            onDrop: function(table, row) {
                $.post("reOrderRundown.php",{runID:<?php echo($rID); ?>,order:$.tableDnD.serialize()},function(data,status){showMessage(data);refreshTime();});
                prettyPrint();
            },dragHandle: ".dragHandle"
        });
</script>