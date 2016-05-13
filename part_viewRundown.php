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
	
    if ($rID!="" && $newsID!=""){
        $sqlItem="select * from rundownitem where runID='$rID' order by seq desc";
        $result = $conn->query($sqlItem);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $seq=$row["seq"]+1;
            }
        } else {
            $seq=1;
        }
        $sqlItem="insert into rundownitem (runID,scID,seq,duration) values ('$rID','$newsID',$seq,'$duration')";
        $result = $conn->query($sqlItem);
    }
    if ($rID!="" && $delID!=""){
        $sqlItem="delete from rundownitem where (runID='$rID' and scID='$delID')";
        echo($sqlItem);
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
                while($row = $result->fetch_assoc()){
                    $print="<img src='images/printer.png' width='25' height='25' style='cursor:hand' border='0' onclick=\"printScript('" .  $row["scID"] . "')\">";
                    if (strpos($row["title"],"reak_")>0) {
                        $dragMode="nodrag";
                        $table=$table . "<tr id=" . $row["scID"] . " class='$dragMode'><td></td><td nowrap>" . $row["title"] . "</td><td><input type='hidden' name='txtNewsID' value=" . $row["scID"] . "/></td><td></td><td></td></tr>";
                    } else {
                        $dragMode="dragHandle";
                        $table=$table . "<tr id='" . $row["scID"] . "'  class='dragItem'><td>$print</td><td nowrap>" . $row["scriptHeader"] . "</td><td><input type='hidden' name='txtNewsID' value='" . $row["scID"] . "'/>" . $row["scriptTime"] . "</td><td nowrap></td><td nowrap> $bin</td></tr>";
                    }

                }
            }
        }
    }
$conn->close();
}
?>
  <table id="table-3" cellspacing="1" cellpadding="3" width="90%">
    <tr class="nodrop">
        <th><input name="txtRundown" id="txtRundown" type="hidden" value="<?php echo($rID) ?>"></th>
        <th>ข่าว</th>
        <th>เวลา</th>
        <th nowrap><!--เวลารวม--></th>
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
                $.post("reOrderRundown.php",{runID:<?php echo($rID); ?>,order:$.tableDnD.serialize()},function(data,status){showMessage(data);});
                prettyPrint();
            },dragHandle: ".dragHandle"
        });
</script>