<?php
/**
 * User: Yarzar
 * Date: 1/6/2018
 * Time: 11:54 PM
 */

$base_url = "http://localhost/mmtxt/";
define("BR","<br>");
define("HR","<hr>");
$url = $_SERVER['REQUEST_URI'];
$url = preg_replace('/[a-zA-Z0-9\/\.\-]+(api\/)/i','', $url);
$segs = explode("/", $url);
#if(!isset($seg[3]) || strtolower(trim($seg[3]))!="zg") $seg[3]="un";
#echo file_get_contents($base_url."api.php?p=".intval($seg[0])."&mins=".intval($seg[1])."&maxs=".intval($seg[2])."&enc=".$seg[3]);

foreach ($segs as $seg)
{
    $seg = trim(strtolower($seg));
    $html = "html";
    if(preg_match('/(para)[0-9]+/', $seg))
    {
        $paragraph = str_replace("para", "", $seg)*1;
    }
    if(preg_match('/(min)[0-9]+/', $seg))
    {
        $minimum = str_replace("min", "", $seg)*1;
    }
    if(preg_match('/(max)[0-9]+/', $seg))
    {
        $maximum = str_replace("max", "", $seg)*1;
    }
    if($seg=="zg")
    {
        $encoding = "zg";
    }
    if($seg=="uni")
    {
        $encoding = "uni";
    }
    if($seg=="plain")
    {
        $html = "plain";
    }
}

if(!isset($paragraph)) $paragraph = 4;
if(!isset($minimum)) $minimum = 2;
if(!isset($maximum)) $maximum = 6;
if(!isset($encoding)) $encoding = 'zg';


#echo $base_url."api.php?p=".$paragraph."&min=".$minimum."&max=".$maximum."&enc=".$encoding."&html=".$html."<hr>";
echo file_get_contents($base_url."api.php?p=".$paragraph."&min=".$minimum."&max=".$maximum."&enc=".$encoding."&html=".$html);


?>


