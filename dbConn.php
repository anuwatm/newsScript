<?php
header('Content-Type: text/html; charset=utf-8');
define("ENCRYPTION_KEY", "workpoint");

session_save_path("tmp/");
$pathScript="script/";
session_start();

$servername = "10.1.75.91";
$username = "003710";
$password = "352131711";
$dbname = "newsScript";

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function date_getFullTimeDifference( $start, $end )
{
$uts['start']      =    strtotime( $start );
        $uts['end']        =    strtotime( $end );
        if( $uts['start']!==-1 && $uts['end']!==-1 )
        {
            if( $uts['end'] >= $uts['start'] )
            {
                $diff    =    $uts['end'] - $uts['start'];
                if( $years=intval((floor($diff/31104000))) )
                    $diff = $diff % 31104000;
                if( $months=intval((floor($diff/2592000))) )
                    $diff = $diff % 2592000;
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
                return( array('years'=>$years,'months'=>$months,'days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
            }
            else
            {
                echo "Ending date/time is earlier than the start date/time";
            }
        }
        else
        {
            echo "Invalid date/time data detected";
        }
}

function clean_string($string) {
  $s = trim($string);
  $s = iconv("UTF-8", "UTF-8//IGNORE", $s);
  $s = preg_replace('/(?>[\x00-\x1F]|\xC2[\x80-\x9F]|\xE2[\x80-\x8F]{2}|\xE2\x80[\xA4-\xA8]|\xE2\x81[\x9F-\xAF])/', ' ', $s);

  $s = preg_replace('/\s+/', ' ', $s); 

  return $s;
}

function utf8_for_xml($string){
  return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'WorkPoint';
    $secret_iv = 'newsScript';

    $key = hash('sha256', $secret_key);
    
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
function checkSessionTimeOut(){
	$session_life = time() - $_SESSION['timeout'];
	if(intval($session_life) > (30*60)) {
		session_destroy();
        header("Location: index.php");
        die();
		return "timeout";
	} else {
		$_SESSION['timeout']=time();
		return "intime";
	}
}

function canAccess($page){
    if($_SESSION['permission']==1){
        return 1;
    }
    if($_SESSION['permission']==2){
        if ($page!="/hotnews/manage.php"){
            return 1;
        } else {
            return 0;
        }
    }
    if($_SESSION['permission']==3){
        if ($page="/hotnews/nc.php"){
            return 1;
        } else {
            return 0;
        }
    }
    if($_SESSION['permission']==4){
        if ($page="/hotnews/backoffice.php"){
            return 1;
        } else {
            return 0;
        }
    }
}

function right($string, $length){
	$str = substr($string, -$length, $length);
	return $str;
}

function writeXMLFile($filename,$content) { 
        $f=fopen($filename,"w"); 
        fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
        fwrite($f,"<?xml version='1.0' encoding='UTF-8'?>$content"); 
        fclose($f); 
}

function writeTXTFile($filename,$content) { 
        $f=fopen($filename,"w"); 
        fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
        fwrite($f,$content); 
        fclose($f); 
}
function jsonRemoveUnicodeSequences($struct) {
   return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}
function readPermission($codePremit){
	switch ($codePremit){
		case 1:
			$permissionName="Read";
			break;
		case 2:
			$permissionName="Read/Write";
			break;
		default:
			$permissionName="-";
	}
	return $permissionName;
}

function permitOther($val){
	switch ($val){
		case 0:
			$show="<img src='images/no.png'>";
			break;
		case 1:
			$show="<img src='images/Check.png'>";
			break;
		default:
			$show="-";
	}
	return $show;
}
function cleanString($string) {
   $string = str_replace(' ', '', $string);

   return preg_replace('/[^A-Za-zก-ฮ0-9\-]/', '', $string);
}
?>