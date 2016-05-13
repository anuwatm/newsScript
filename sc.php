<?php
header('Content-Type: text/html; charset=utf-8');
//require "dbConn.php";

$conn1 = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn1,"utf8");

class newsScript{
    public $scID="";
    public $runID='';
    public $dateCode='';
    public $title='';
    public $script='';
    public $duration='';
    public $statusID='';
    public $createBy='';
    public $typeID='';
    public $cBy='';
    public $cDate='';
    public $mBy='';
    public $mDate='';
    public $tblID='';
    public $tblName='';
    public $proID='';
    public $proName='';
    public $dateOnAir='';
    public $timeOnAir='';
    
    public function getScriptOnly($scriptDesc){
        
        $content=str_replace('<img src="images/[.png" alt="" />','|[',$scriptDesc);
        $content=str_replace('<img src="images/].png" alt="" />',']',$content);
        $content=str_replace('<img src="images/].png" alt="" width="14" height="25" />',']',$content);

        $pContent=explode("|",strip_tags($content));
        //$cPreview
        /*foreach($pContent as $val){
            $splitContent=explode("]",$val);
            
            //echo(count($splitContent));
            //print_r($splitContent);
            //echo($val);
        }*/
        return strip_tags($content);
        //print_r($packContent);
        
    }
    public function setStatusNow($oldStatus){
        $status=1;
        switch($oldStatus){
            case "":
                $status=1;
                break;
            case 1:
                $status=1;
                break;
            case 2:
                $status=4;
                break;
            case 4:
                $status=4;
                break;
            case 5:
                $status=4;
                break;
        }
        return $status;
    }
    
    public function setMenuMe($statusID,$owner,$user,$permissionME,$approve,$other){
        $menu="";
        switch($statusID){
            case "1":
                if ($owner==$user){
                    if ($permissionME==2){
                        $menu="mnufull";
                    } else {
                        $menu="mnuPrint";
                    }
                        
                } else {
                    $menu="mnuView";
                }
                break;
            case "2":
                if ($owner==$user){
                    if($approve=="1"){
                        $menu="mnufull";
                    } else {
                        $menu="mnuView";
                    }
                } else {
                   $menu="mnuPrint";
                }
                break;
            case "3":
                $menu="mnuPrint";
                break;
            case "4":
                if ($owner==$user && $approve==1){
                    $menu="mnufull";
                } else {
                    $menu="mnuPrint";
                }
				break;
            case "5":
				$menu="mnuPrint";
				break;
        }
        return $menu;
    }
    public function setMenuTable($statusID,$owner,$user,$tblID,$approve,$other){
        $menu="";
        switch($statusID){
            case "1":
                if ($owner==$user){
                    $menu="mnufull";
                } else {
                    $menu="mnuView";
                }
                break;
            case "2":
                if($approve==1){
                    if ($other==1){
                        $menu="mnufull";
                    } else {
                        $menu="mnuView";
                    }
                } else {
                    $menu="mnuPrint";
                }
                break;
            case "3":
                $menu="mnuPrint";
                break;
            case "4":
                if ($owner==$user && $approve==1){
                    $menu="mnufull";
                } else {
                    $menu="mnuPrint";
                }
                break;
            case "5":
                if ($owner==$user && $approve==1){
                    $menu="mnufull";
                } else {
                    $menu="mnuPrint";
                }
                break;
        }
        return $menu;
    }
    public function cleanSPstring($source){
        return str_replace( array(' ','<', '>','่','้','๊','็','๋','์','ิ','ื','ี','ึ','ู','ุ','เ','แ','า','ำ','ไ','ใ','ฯ','ๆ','.',',','!','?','&','$','*','-','/','|','%','+',':','(',')','โ','ไ','ใ','nbsp;','rdquo;','ldquo;','ั'), '', $source);
    }
    public function calcDuration($script){
        $content=$this->getScriptOnly($script);
        $pContent=explode("|",$content);
        $contentScript="";
        foreach($pContent as $val){
            $pc=explode("]",$val);
            if (count($pc)>1){
                $contentScript=$contentScript . $pc[1];
            } else {
                if (strpos($pc[0],"[",0)<1){
                    $contentScript=$contentScript . $pc[0];
                }
            }
        }
        $contentScript=$this->cleanSPstring($contentScript);
        //echo($contentScript);
        $contentScript=cleanString($contentScript);
        
        $lenScript=strlen($contentScript);
        $Range = ($lenScript / 12);
        $minute=(int)($Range/60);
        $second=(int)$Range % 60;
        $second=substr("00$second",-2);
        return $minute . "." . $second;
    }
    
    public function printScriptByStatus($scID,$statusID){
        if (file_exists("script/" . $scID . "_" . $statusID . ".txt")>0){
            $printContent="<img src='images/preview_context.png' style='width:25px;height:25px;cursor:hand' onclick=\"printScriptStatus('$scID','$statusID')\">";
        }
        return $printContent;
    }
    public function readScriptByStatus($scID,$statusID){
        $ns= fopen("script/" . $scID . "_" . $statusID . ".txt", "r") or die("");
        $scriptBody= fread($ns,filesize("script/" . $scID . "_" . $statusID . ".txt"));
        fclose($ns);
        return $scriptBody;
    }
    public function toSeconds($source) {
        $time1 = explode('.',$source);
        //echo($source . "[" . $time1[0] . "]");
        switch (count($time1)){
            case 0:
                return $source;
                break;
            case 1:
                return $source;
                break;
            case 2:
                return (($time1[0] * 60) + $time1[1]);
                break;
            case 3:
                return $time1[0] * 3600 + $time1[1] * 60 + $time1[2];
                break;
        }
    }
    public function set2Digit($source){
        return substr("0" . $source, -2);
    }
    public function setPermit($value){
        $option="<option value=''></option>";
        if ($value=="1"){$option="$option<option value='1' selected>อ่าน</option>";} else{$option="$option<option value='1'>อ่าน</option>";}
        if ($value=="2"){$option="$option<option value='2' selected>อ่าน/เขียน</option>";} else{$option="$option<option value='2'>อ่าน/เขียน</option>";}
        return $option;
    }
}

?>