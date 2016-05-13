<?php
require "dbConn.php";

checkSessionTimeOut();
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

checkSessionTimeOut();

if ($conn->connect_error) {
    //Fail Connection
} else {
	//Sucess Connection
	$sql = "SELECT * FROM vUser Where (usrName='" . $_SESSION["usrName"]  . "')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $fullname=$row["fullName"];
            $type=$row["tyName"];
            $table=$row["tblName"];
            $program=$row["proName"];
        }
    }
    $conn->close();
}
?>

<link href="css/css3-buttons.css" rel="stylesheet" type="text/css">
<ul style="list-style-type: none;font-size:8pt;color:gray;">
    <li ><label style="text-align:right;width:120px;">ชื่อ - นามสกุล : </label><?php echo($fullname); ?></li>
    <li ><label style="text-align:right;width:120px;">ประเภท : </label><?php echo($type); ?></li>
    <li ><label style="text-align:right;width:120px;">โต๊ะข่าว : </label><?php echo($table); ?></li>
    <li ><label style="text-align:right;width:120px;">รายการ : </label><?php echo($program); ?></li>
    <li ><label style="text-align:right;width:120px;">รหัสผ่านใหม่ : </label><input type="Password" id="txtNewPWD" name="txtNewPWD" autocomplete="off"  placeholder="กรุณากรอก Password"></li>
    <li ><label style="text-align:right;width:120px;">รหัสผ่านใหม่อีกครั้ง : </label><input type="Password" id="txtConfirmPWD" name="txtConfirmPWD" autocomplete="off"  placeholder="กรุณากรอก Password"></li>
    <li ><button class="button middle" onclick="javascript:changePWD();">บันทึก</button></li>
</ul>
