<?php
/**
 * User: Yarzar
 * Date: 1/6/2018
 * Time: 11:54 PM
 */
define("BR","<br>");
define("HR","<hr>");
require_once "config.php";

if($_SERVER['HTTP_HOST'] != preg_replace("/(http:)[\/]+/","",BASE_URL))
{
	die('<meta http-equiv="refresh" content="0;URL='.BASE_URL.'" />');
}

$base_url = BASE_URL;
$folder = FOLDER;

$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace_first($folder."/","", $uri);
//die($uri );
$segs = explode("/", $uri);

if(strtolower($segs[0]) == "api")
{
    $html = "html";
    $ctx = "sport";
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

        for($i=0; $i < count($context); $i++){
            if($seg==$context[$i]){
                $ctx = $seg;
            }
        }
    }



    if(!isset($paragraph)) $paragraph = 4;
    if(!isset($minimum)) $minimum = 2;
    if(!isset($maximum)) $maximum = 6;
    if(!isset($encoding)) $encoding = 'zg';

    echo file_get_contents($base_url.$folder."/api.php?p=$paragraph&min=$minimum&max=$maximum&enc=$encoding&html=$html&context=$ctx");
}
else
{
    include "ui.php";
}

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}

?>


