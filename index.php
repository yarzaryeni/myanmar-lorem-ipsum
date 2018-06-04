<?php
/**
 * User: Yarzar
 * Date: 1/6/2018
 * Time: 11:54 PM
 */
define("BR","<br>");
define("HR","<hr>");
require "config.php";

$base_url = $conf["base_url"];
$folder = $conf["folder"];

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace($folder."/","", $uri);
$segs = explode("/", $uri);

if(strtolower($segs[0]) == "api")
{
    $html = "html";
    foreach ($segs as $seg)
    {
        $seg = trim(strtolower($seg));
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

    echo file_get_contents($base_url.$folder."/api.php?p=".$paragraph."&min=".$minimum."&max=".$maximum."&enc=".$encoding."&html=".$html);
}
else
{
    include "ui.php";
}


?>


